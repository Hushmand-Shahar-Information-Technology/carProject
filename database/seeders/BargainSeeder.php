<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bargain;
use App\Models\User;
use Illuminate\Support\Str;

class BargainSeeder extends Seeder
{
    public function run()
    {
        // Create a seller user for the bargain
        $sellerUser = User::factory()->create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
            'role' => 'car_seller',
            'email_verified_at' => now(),
        ]);

        // Create some seeker users
        $seekerUsers = User::factory()->count(3)->create([
            'role' => 'car_seeker',
            'email_verified_at' => now(),
        ]);

        // Create some bargain records
        for ($i = 1; $i <= 5; $i++) {
            Bargain::create([
                'seller_id' => $sellerUser->id,
                'seeker_id' => $i <= 3 ? $seekerUsers[$i-1]->id : null,
                'details' => 'Sample bargain details ' . $i,
                'price' => rand(10000, 50000),
                'status' => ['open', 'negotiation', 'closed'][rand(0, 2)],
            ]);
        }
    }
}