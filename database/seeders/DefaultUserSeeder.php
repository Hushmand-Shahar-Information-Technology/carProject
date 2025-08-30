<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default user if it doesn't exist
        User::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Default User',
                'email' => 'default@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Default user created successfully!');
    }
}
