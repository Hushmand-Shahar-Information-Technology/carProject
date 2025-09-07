<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Car;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class ActivityLogTest extends TestCase
{
    /**
     * Test that activity logging is working for models.
     *
     * @return void
     */
    public function test_activity_logging_works()
    {
        // Create a user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create a car
        $car = Car::create([
            'title' => 'Test Car',
            'year' => 2020,
            'user_id' => $user->id,
            'make' => 'Toyota',
            'model' => 'Camry',
            'car_color' => 'Red',
            'transmission_type' => 'automatic',
        ]);

        // Check that an activity was logged for creating the car
        $this->assertDatabaseHas('activity_log', [
            'subject_type' => 'App\Models\Car',
            'event' => 'created',
            'description' => 'created',
        ]);

        // Update the car
        $car->update(['title' => 'Updated Test Car']);

        // Check that an activity was logged for updating the car
        $this->assertDatabaseHas('activity_log', [
            'subject_type' => 'App\Models\Car',
            'event' => 'updated',
            'description' => 'updated',
        ]);

        // Delete the car
        $car->delete();

        // Check that an activity was logged for deleting the car
        $this->assertDatabaseHas('activity_log', [
            'subject_type' => 'App\Models\Car',
            'event' => 'deleted',
            'description' => 'deleted',
        ]);
    }
}