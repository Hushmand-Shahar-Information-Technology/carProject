<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\User;
use App\Models\Bargain;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'year' => $this->faker->numberBetween(2000, 2023),
            'make' => $this->faker->randomElement(['Toyota', 'Honda', 'BMW', 'Mercedes', 'Ford', 'Chevrolet']),
            'model' => $this->faker->word,
            'car_color' => $this->faker->colorName,
            'transmission_type' => $this->faker->randomElement(['manual', 'automatic']),
            'regular_price' => $this->faker->numberBetween(10000, 100000),
            'currency_type' => 'USD',
            'is_for_sale' => true,
            'user_id' => User::factory(),
            'bargain_id' => null,
        ];
    }
}
