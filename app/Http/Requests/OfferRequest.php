<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
            'mao_name' => 'required|string|max:255',
            'mao_phone' => 'required|string|max:20',
            'mao_email' => 'required|email|max:255',
            'mao_price' => 'required|numeric|min:0.01',
            'mao_car_id' => 'required|exists:cars,id',
            'mao_comments' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'mao_name.required' => 'Name is required.',
            'mao_phone.required' => 'Phone number is required.',
            'mao_email.required' => 'Email address is required.',
            'mao_email.email' => 'Please enter a valid email address.',
            'mao_price.required' => 'Offered price is required.',
            'mao_price.numeric' => 'Offered price must be a valid number.',
            'mao_price.min' => 'Offered price must be greater than 0.',
            'mao_car_id.required' => 'Car information is missing.',
            'mao_car_id.exists' => 'Invalid car selected.',
        ];
    }
}
