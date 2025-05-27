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
    public function rules(): array{
        return [
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:1990|max:' . now()->year,
            'make' => 'required|string',
            'body_type' => 'required|string',
            'car_condition' => 'required|string',
            'VIN_number' => 'required',
            'location' => 'required|string',
            'model' => 'required|string',
            'car_color' => ['required', Rule::in(array_map(fn($color) => $color->value, CarColor::values()))],
            'car_inside_color' => 'required|string',
            'car_documents' => 'nullable|string',
            'transmission_type' => 'required|string',
            'currency_type' => 'required|string',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0|lte:regular_price',
            'images' => 'required|array|min:1|max:11',
            'images.*' => 'file|image|max:5120',
            'videos' => 'nullable|array|max:2',
            'videos.*' => 'file|mimetypes:video/mp4,video/avi,video/mpeg|max:10240',
        ];
    }


}
