<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BargainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Get the ID from the route parameter for update, or null for store
        $bargainId = $this->route('id') ?? null;

        return [
            'name' => [
                'required',
                'max:255',
                // Ignore current record when updating
                Rule::unique('bargains', 'name')->ignore($bargainId),
            ],
            'username' => [
                'required',
                'max:255',
                Rule::unique('bargains', 'username')->ignore($bargainId),
            ],
            'profile_image' => ['nullable', 'image', 'max:2048'],
            'website' => ['nullable', 'url'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string'],
            'whatsapp' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'contract_start_date' => ['nullable', 'date'],
            'contract_end_date' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter the name.',
            'username.required' => 'Please enter the username.',
            'profile_image.image' => 'Profile image must be an image file.',
            'website.url' => 'Please enter a valid website URL.',
            'email.email' => 'Please enter a valid email address.',
            'contract_start_date.date' => 'Contract start date must be a valid date.',
            'contract_end_date.date' => 'Contract end date must be a valid date.',
        ];
    }
}
