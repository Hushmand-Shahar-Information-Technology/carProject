<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Bargain;
use Illuminate\Support\Str;

class BargainSeeder extends Seeder
{
    public function run()
    {
        $names = ['AutoHub', 'CarPoint', 'DriveNow', 'Wheels4U', 'MotorLand'];
        $usernames = ['autohub', 'carpoint', 'drivenow', 'wheels4u', 'motorland'];
        $websites = [
            'https://autohub.test',
            'https://carpoint.test',
            'https://drivenow.test',
            'https://wheels4u.test',
            'https://motorland.test',
        ];

        foreach ($names as $index => $name) {
            Bargain::create([
                'name' => $name,
                'username' => $usernames[$index],
                'profile_image' => null, // or some seeded image path
                'website' => $websites[$index],
                'email' => $usernames[$index] . '@example.com',
                'registration_number' => strtoupper(Str::random(10)),
                'phone' => '+1-555-' . rand(1000, 9999),
                'whatsapp' => '+1-555-' . rand(1000, 9999),
                'address' => '123 ' . $name . ' Street, City, Country',
                'contract_start_date' => now()->subMonths(rand(1, 12))->toDateString(),
                'contract_end_date' => now()->addMonths(rand(1, 12))->toDateString(),
                'edit_frequent' => rand(0, 5),
                'status' => rand(0, 1) ? 'one-time' : 'more-time',
            ]);
        }
    }
}