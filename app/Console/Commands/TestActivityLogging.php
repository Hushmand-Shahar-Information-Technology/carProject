<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Car;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class TestActivityLogging extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:test {--count=5 : Number of test records to create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the activity logging system by creating sample records';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = $this->option('count');
        
        $this->info("Creating {$count} test cars with activity logging...");
        
        // Create a user if none exists
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
            $this->info("Created test user: {$user->name}");
        }
        
        // Create test cars
        for ($i = 1; $i <= $count; $i++) {
            $car = Car::create([
                'title' => "Test Car {$i}",
                'year' => 2020 + $i,
                'user_id' => $user->id,
                'make' => 'Toyota',
                'model' => 'Camry',
                'car_color' => 'Red',
                'transmission_type' => 'automatic',
            ]);
            
            $this->info("Created car: {$car->title}");
            
            // Update the car to generate an update log
            $car->update([
                'title' => "Updated Test Car {$i}",
                'year' => 2021 + $i,
            ]);
            
            $this->info("Updated car: {$car->title}");
        }
        
        // Show activity log summary
        $activityCount = Activity::count();
        $this->info("Total activities logged: {$activityCount}");
        
        $carActivities = Activity::where('subject_type', Car::class)->count();
        $this->info("Car activities: {$carActivities}");
        
        $this->info("Recent activities:");
        $recentActivities = Activity::latest()->take(10)->get();
        
        foreach ($recentActivities as $activity) {
            $subject = $activity->subject;
            $subjectInfo = $subject ? get_class($subject) . " (ID: {$subject->id})" : 'Unknown';
            $this->line("- {$activity->description} on {$subjectInfo} at {$activity->created_at}");
        }
        
        return 0;
    }
}