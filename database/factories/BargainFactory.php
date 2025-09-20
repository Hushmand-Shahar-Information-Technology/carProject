<?php

namespace Database\Factories;

use App\Models\Bargain;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BargainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bargain::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'status' => $this->faker->randomElement(['one-time', 'more-time']),
            'registration_status' => 'approved',
            'registration_number' => $this->faker->unique()->numerify('BN####'),
            'user_id' => User::factory(),
        ];
    }
}
