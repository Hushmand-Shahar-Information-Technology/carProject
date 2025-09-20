<?php

namespace Tests\Feature;

use App\Models\Bargain;
use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BargainCarRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $bargain;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user
        $this->user = User::factory()->create();

        // Create a bargain for the user
        $this->bargain = Bargain::factory()->create([
            'user_id' => $this->user->id,
            'registration_status' => 'approved'
        ]);
    }

    /** @test */
    public function cars_registered_in_bargain_mode_are_displayed_in_bargain_profile()
    {
        // Acting as the user
        $this->actingAs($this->user);

        // Create a car associated with the bargain
        $car = Car::factory()->create([
            'user_id' => $this->user->id,
            'bargain_id' => $this->bargain->id,
            'make' => 'Toyota',
            'model' => 'Camry',
            'year' => 2020,
            'is_for_sale' => true,
            'regular_price' => 25000,
            'currency_type' => 'USD'
        ]);

        // Visit the user profile page with bargain_id parameter
        $response = $this->get(route('user.profile', ['bargain_id' => $this->bargain->id]));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the car is displayed in the bargain profile
        $response->assertSee($car->make);
        $response->assertSee($car->model);
        $response->assertSee((string) $car->year);
        $response->assertSee('For Sale');
        $response->assertSee(number_format($car->regular_price));

        // Assert that the bargain name is displayed in the profile title
        $response->assertSee($this->bargain->name);
    }

    /** @test */
    public function cars_registered_in_user_mode_are_displayed_in_user_profile()
    {
        // Acting as the user
        $this->actingAs($this->user);

        // Create a car associated with the user (not bargain)
        $car = Car::factory()->create([
            'user_id' => $this->user->id,
            'bargain_id' => null,
            'make' => 'Honda',
            'model' => 'Civic',
            'year' => 2019,
            'is_for_sale' => true,
            'regular_price' => 20000,
            'currency_type' => 'USD'
        ]);

        // Visit the user profile page without bargain_id parameter
        $response = $this->get(route('user.profile'));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the car is displayed in the user profile
        $response->assertSee($car->make);
        $response->assertSee($car->model);
        $response->assertSee((string) $car->year);
        $response->assertSee('For Sale');
        $response->assertSee(number_format($car->regular_price));

        // Assert that the user name is displayed in the profile title
        $response->assertSee($this->user->name);
    }

    /** @test */
    public function bargain_cars_are_displayed_in_bargain_show_page()
    {
        // Acting as the user
        $this->actingAs($this->user);

        // Create a car associated with the bargain
        $car = Car::factory()->create([
            'user_id' => $this->user->id,
            'bargain_id' => $this->bargain->id,
            'make' => 'BMW',
            'model' => 'X5',
            'year' => 2021,
            'is_for_sale' => true,
            'regular_price' => 55000,
            'currency_type' => 'USD'
        ]);

        // Visit the bargain show page
        $response = $this->get(route('bargains.show', $this->bargain->id));

        // Assert that the response is successful
        $response->assertStatus(200);

        // Assert that the car is displayed in the bargain show page
        $response->assertSee($car->make);
        $response->assertSee($car->model);
        $response->assertSee((string) $car->year);
        $response->assertSee('For Sale');
        $response->assertSee(number_format($car->regular_price));
    }
}
