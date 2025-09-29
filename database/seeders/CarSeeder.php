<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\User;
use App\Models\Bargain;
use App\Enums\TransmissionType;

class CarSeeder extends Seeder
{
    public function run()
    {
        $titles = ['Honda Accord', 'Toyota Camry', 'Ford Mustang', 'BMW X5', 'Audi A4'];
        $years = ['2005', '2010', '2015', '2020', '2022'];
        $makes = ['Honda', 'Toyota', 'Ford', 'BMW', 'Audi'];
        $bodyTypes = ['Sedan', 'SUV', 'Coupe', 'Convertible', 'Hatchback'];
        $carConditions = ['New', 'Used', 'Certified Pre-Owned'];
        $carColors = ['black', 'white', 'red', 'blue', 'gray'];
        $carInsideColors = ['Beige', 'Black', 'Gray'];
        $documents = ['Title', 'Registration', 'Insurance'];
        $models = ['Accord', 'Camry', 'Mustang', 'X5', 'A4'];
        $currencyTypes = ['USD', 'EUR', 'JPY'];

        // ✅ Ensure there is at least one user
        $userIds = User::pluck('id')->toArray();
        if (empty($userIds)) {
            $defaultUser = User::factory()->create([
                'name' => 'Default User',
                'email' => 'default@example.com',
                'password' => bcrypt('password'),
            ]);
            $userIds = [$defaultUser->id];
        }


        $imagesList = [
            ['images/car/01.jpg', 'images/car/02.jpg'],
            ['images/car/03.jpg', 'images/car/04.jpg'],
            ['images/car/05.jpg', 'images/car/06.jpg'],
            ['images/car/06.jpg', 'images/car/06.jpg'],
            ['images/car/07.jpg', 'images/car/06.jpg'],
            ['images/car/08.jpg', 'images/car/06.jpg'],
            ['images/car/09.jpg', 'images/car/06.jpg'],
            ['images/car/10.jpg', 'images/car/06.jpg'],
            ['images/car/11.jpg', 'images/car/06.jpg'],
            ['images/car/12.jpg', 'images/car/06.jpg'],
            ['images/car/13.png', 'images/car/14.png'],
            ['images/car/15.jpg', 'images/car/16.jpg'],
            ['images/car/17.jpg', 'images/car/18.png'],
            ['images/car/19.jpg', 'images/car/21.jpg'],
            ['images/car/22.jpg', 'images/car/23.png'],
            ['images/car/24.jpg', 'images/car/25.jpg'],
        ];

        $videosList = [
            ['videos/car/01.mp4'],
            ['videos/car/02.mp4'],
            [],
        ];

        // ✅ Generate 10 cars always linked to a bargain
        for ($i = 0; $i < 10; $i++) {
            Car::create([
                'title' => $titles[array_rand($titles)],
                'user_id' => $userIds[array_rand($userIds)],
                'year' => $years[array_rand($years)],
                'make' => $makes[array_rand($makes)],
                'body_type' => $bodyTypes[array_rand($bodyTypes)],
                'car_condition' => $carConditions[array_rand($carConditions)],
                'car_color' => $carColors[array_rand($carColors)],
                'car_documents' => $documents[array_rand($documents)],
                'car_inside_color' => $carInsideColors[array_rand($carInsideColors)],
                'VIN_number' => strtoupper(bin2hex(random_bytes(8))),
                'location' => '34.532493, 69.121091',
                'model' => $models[array_rand($models)],
                'transmission_type' => TransmissionType::cases()[array_rand(TransmissionType::cases())]->value,
                'currency_type' => $currencyTypes[array_rand($currencyTypes)],
                'regular_price' => rand(10000, 50000),

                'description' => 'Seeded demo car for testing.',
                'is_for_sale' => (bool)rand(0, 1),
                'is_for_rent' => (bool)rand(0, 1),
                'is_promoted' => (bool)rand(0, 1),
                'rent_price_per_day' => rand(0, 1) ? rand(50, 200) : null,
                'rent_price_per_month' => rand(0, 1) ? rand(1000, 5000) : null,
                'request_price_status' => (bool)rand(0, 1),
                'request_price' => rand(1000, 4000),
                'images' => $imagesList[array_rand($imagesList)],
                'videos' => $videosList[array_rand($videosList)],
            ]);
        }
    }
}
