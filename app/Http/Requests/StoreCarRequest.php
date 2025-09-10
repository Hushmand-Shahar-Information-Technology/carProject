<?php

namespace App\Http\Requests;

use App\Enums\CarColor;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Always required fields
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . now()->year,
            'make' => 'required|string',
            'car_color' => 'required|string',
            
            // Conditional fields - only required for sale
            'body_type' => 'nullable|string',
            'car_condition' => 'nullable|string', 
            'VIN_number' => 'nullable|string',
            'location' => 'nullable|string',
            'model' => 'nullable|string',
            'car_inside_color' => 'nullable|string',
            'car_documents' => 'nullable|string',
            'transmission_type' => 'nullable|string',
            'currency_type' => 'nullable|string',
            'description' => 'nullable|string',
            
            // Purpose selections
            'is_for_sale' => 'sometimes|boolean',
            'is_for_rent' => 'sometimes|boolean',
            'is_promoted' => 'sometimes|boolean',
            'bargain_id' => 'nullable|exists:bargains,id',
            
            // Price fields - conditional validation in withValidator
            'regular_price' => 'nullable|numeric|min:0',

            'rent_price_per_day' => 'nullable|numeric|min:0',
            'rent_price_per_month' => 'nullable|numeric|min:0',
            
            // Media files - updated limits
            'images' => 'required|array|min:1|max:60',
            'images.*' => 'required|file|image|mimes:jpeg,jpg,png,gif,webp,svg|max:20480',
            'videos' => 'nullable|array|max:60',
            'videos.*' => 'nullable|file|mimes:mp4,avi,mpeg,mov,wmv,3gp,3gpp,webm,ogg,mkv|max:204800',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $request = $validator->getData();
            $isForSale = filter_var($request['is_for_sale'] ?? false, FILTER_VALIDATE_BOOLEAN);
            $isForRent = filter_var($request['is_for_rent'] ?? false, FILTER_VALIDATE_BOOLEAN);

            // Check that at least one purpose is selected
            if (!$isForSale && !$isForRent) {
                $validator->errors()->add('is_for_sale', 'Please select if the car is for sale or rent.');
                return;
            }

            // Validation for sale-specific fields
            if ($isForSale) {
                $requiredSaleFields = [
                    'body_type' => 'Body type is required when selling.',
                    'car_condition' => 'Car condition is required when selling.',
                    'VIN_number' => 'VIN number is required when selling.',
                    'model' => 'Model is required when selling.',
                    'car_inside_color' => 'Interior color is required when selling.',
                    'car_documents' => 'Car documents are required when selling.',
                    'transmission_type' => 'Transmission type is required when selling.',
                    'currency_type' => 'Currency type is required when selling.',
                ];

                foreach ($requiredSaleFields as $field => $message) {
                    if (empty($request[$field])) {
                        $validator->errors()->add($field, $message);
                    }
                }

                // Price validation for sale - regular price is optional
                $regularPrice = $request['regular_price'] ?? null;

                // Only validate if prices are provided (making them optional)
                if (!empty($regularPrice) && $regularPrice <= 0) {
                    $validator->errors()->add('regular_price', 'Regular price must be greater than 0 if provided.');
                }
            }

            // Validation for rent-specific fields
            if ($isForRent) {
                $dayPrice = $request['rent_price_per_day'] ?? null;
                $monthPrice = $request['rent_price_per_month'] ?? null;
                
                // At least one rent price is required
                if ((empty($dayPrice) || $dayPrice <= 0) && (empty($monthPrice) || $monthPrice <= 0)) {
                    $validator->errors()->add('rent_price_per_day', 'Provide rent per day or rent per month.');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'sale_price.lte' => 'Sale price must be less than or equal to regular price.',
            'images.required' => 'At least one image is required.',
            'images.array' => 'Images must be an array of files.',
            'images.min' => 'At least one image is required.',
            'images.max' => 'Maximum 60 images allowed.',
            'images.*.image' => 'Each image must be a valid image file.',
            'images.*.mimes' => 'Images must be jpeg, jpg, png, gif, webp, or svg.',
            'images.*.max' => 'Each image must be less than 20MB.',
            'videos.array' => 'Videos must be an array of files.',
            'videos.max' => 'Maximum 60 videos allowed.',
            'videos.*.mimes' => 'Videos must be mp4, avi, mpeg, mov, wmv, 3gp, 3gpp, webm, ogg, or mkv.',
            'videos.*.max' => 'Each video must be less than 200MB.',
        ];
    }
}
