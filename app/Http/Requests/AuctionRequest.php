<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Car;

class AuctionRequest extends FormRequest
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
        $carId = $this->input('car_id');
        $car = Car::find($carId);

        return [
            'car_id' => ['required', 'exists:cars,id'],
            'starting_price' => ['required', 'numeric', 'gt:0', function ($attribute, $value, $fail) use ($car) {
                if ($car && $value >= $car->regular_price) {
                    $fail("The starting price must be smaller than the car's regular price ({$car->regular_price}).");
                }
            }],
            'auction_type' => ['required', 'in:fixed,open'],
            'duration_days' => ['nullable', 'integer', 'min:1', 'required_if:auction_type,fixed'],
            'message' => ['nullable', 'string'],
        ];
    }
}
