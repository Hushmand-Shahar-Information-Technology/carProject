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
            'title' => 'required|string|max:255',
            'bargain_id' => 'nullable|exists:bargains,id',
            'year' => 'required|integer|min:1990|max:' . now()->year,
            'make' => 'required|string',
            'body_type' => 'required|string',
            'car_condition' => 'required|string',
            'VIN_number' => 'nullable|string',
            'location' => 'nullable|string',
            'model' => 'required|string',
            'car_color' => 'required|string',
            'car_inside_color' => 'required|string',
            'car_documents' => 'required|string',
            'transmission_type' => 'required|string',
            'currency_type' => 'required|string',
            // Selling fields (required only if is_for_sale is true)
            'is_for_sale' => 'sometimes|boolean',
            'regular_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            // Renting fields (required only if is_for_rent is true)
            'is_for_rent' => 'sometimes|boolean',
            'is_promoted' => 'sometimes|boolean',
            'rent_price_per_day' => 'nullable|numeric|min:0',
            'rent_price_per_month' => 'nullable|numeric|min:0',
            // Description
            'description' => 'nullable|string',
            'images' => 'required|array|min:1|max:11',
            'images.*' => 'required|file|image|mimes:jpeg,jpg,png,gif,webp,svg|max:20480',
            'videos' => 'nullable|array|max:2',
            'videos.*' => 'nullable|file|mimes:mp4,avi,mpeg,mov,wmv,3gp,3gpp,webm,ogg,mkv|max:204800',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $isForSale = filter_var($this->input('is_for_sale', false), FILTER_VALIDATE_BOOLEAN);
            $isForRent = filter_var($this->input('is_for_rent', false), FILTER_VALIDATE_BOOLEAN);

            if ($isForSale) {
                $regularPrice = $this->input('regular_price');
                $salePrice = $this->input('sale_price');

                if ($regularPrice === null || $regularPrice === '' || $regularPrice <= 0) {
                    $validator->errors()->add('regular_price', 'Regular price is required and must be greater than 0 when selling.');
                }
                if ($salePrice === null || $salePrice === '' || $salePrice <= 0) {
                    $validator->errors()->add('sale_price', 'Sale price is required and must be greater than 0 when selling.');
                }

                // Only validate price comparison if both prices are valid numbers
                if (is_numeric($regularPrice) && is_numeric($salePrice)) {
                    if ((float)$salePrice > (float)$regularPrice) {
                        $validator->errors()->add('sale_price', 'Sale price must be less than or equal to regular price.');
                    }
                }
            }

            if ($isForRent) {
                $day = $this->input('rent_price_per_day');
                $month = $this->input('rent_price_per_month');
                if (($day === null || $day === '') && ($month === null || $month === '')) {
                    $validator->errors()->add('rent_price', 'Provide rent per day or rent per month.');
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
            'images.*.image' => 'Each image must be a valid image file.',
            'images.*.mimes' => 'Images must be jpeg, jpg, png, gif, webp, or svg.',
            'images.*.max' => 'Each image must be less than 20MB.',
            'videos.array' => 'Videos must be an array of files.',
            'videos.*.mimes' => 'Videos must be mp4, avi, mpeg, mov, wmv, 3gp, 3gpp, webm, ogg, or mkv.',
            'videos.*.max' => 'Each video must be less than 200MB.',
        ];
    }
}
