<?php

namespace App\Http\Requests;

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
        'year' => 'required|max:4',
        'make' => 'required|string|max:255',
        'VIN_number' => 'nullable|string|max:255',

        'location' => 'nullable',

        'model' => 'required|string|max:255',
        'color' => 'required|string|max:255',
        'transmission_type' => 'nullable|in:automatic,manual',

        'regular_price' => 'nullable|numeric',
        'currency_type' => 'nullable|string|max:10',
        'sale_price' => 'nullable|numeric',

        'images' => 'nullable|array|max:11',
        'images.*' => 'image|mimes:jpg,jpeg,png|max:20000',

        'videos' => 'nullable|array|max:2',
        'videos.*' => 'file|mimetypes:video/mp4,video/avi,video/mpeg|max:200000',
    ];
}

}
