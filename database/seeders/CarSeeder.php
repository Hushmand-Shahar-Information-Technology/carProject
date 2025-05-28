<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Enums\CarColor;
use App\Enums\TransmissionType;
use App\Enums\CarColor;
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
        $carColors = ['black', 'white', 'red', 'blue', 'gray'];  // simple strings now
        $carInsideColors = ['Beige', 'Black', 'Gray'];
        $documents = ['Title', 'Registration', 'Insurance'];
        $models = ['Accord', 'Camry', 'Mustang', 'X5', 'A4'];
        $currencyTypes = ['USD', 'EUR', 'JPY'];
        $transmissionTypes = ['automatic', 'manual', 'semi-automatic'];

        $imagesList = [
            ['images/car/01.jpg', 'images/car/02.jpg'],
            ['images/car/03.jpg', 'images/car/04.jpg'],
            ['images/car/05.jpg', 'images/car/06.jpg'],
        ];
        $videosList = [
            ['videos/car/01.mp4'],
            ['videos/car/02.mp4'],
            [],
        ];

        // Generate 10 cars
        for ($i = 0; $i < 10; $i++) {
            Car::create([
                'title' => $titles[array_rand($titles)],
                'year' => $years[array_rand($years)],
                'make' => $makes[array_rand($makes)],
                'body_type' => $bodyTypes[array_rand($bodyTypes)],
                'car_condition' => $carConditions[array_rand($carConditions)],
                'car_color' => $carColors[array_rand($carColors)],
                'car_documents' => $documents[array_rand($documents)],
                'car_inside_color' => $carInsideColors[array_rand($carInsideColors)],
                'VIN_number' => strtoupper(bin2hex(random_bytes(8))),
                'location' => [
                    'city' => 'Sample City',
                    'state' => 'Sample State',
                    'country' => 'Sample Country'
                ],
                'model' => $models[array_rand($models)],
                'transmission_type' => TransmissionType::cases()[array_rand(TransmissionType::cases())]->value,
                'currency_type' => $currencyTypes[array_rand($currencyTypes)],
                'regular_price' => rand(10000, 50000),
                'sale_price' => rand(5000, 9000),
                'request_price_status' => (bool)rand(0, 1),
                'request_price' => rand(1000, 4000),
                'images' => $imagesList[array_rand($imagesList)],
                'videos' => $videosList[array_rand($videosList)],
            ]);
        }
    }
    public function run()
    {
        $titles = ['Honda Accord', 'Toyota Camry', 'Ford Mustang', 'BMW X5', 'Audi A4'];
        $years = ['2005', '2010', '2015', '2020', '2022'];
        $makes = ['Honda', 'Toyota', 'Ford', 'BMW', 'Audi'];
        $bodyTypes = ['Sedan', 'SUV', 'Coupe', 'Convertible', 'Hatchback'];
        $carConditions = ['New', 'Used', 'Certified Pre-Owned'];
        $carColors = ['black', 'white', 'red', 'blue', 'gray'];  // simple strings now
        $carInsideColors = ['Beige', 'Black', 'Gray'];
        $documents = ['Title', 'Registration', 'Insurance'];
        $models = ['Accord', 'Camry', 'Mustang', 'X5', 'A4'];
        $currencyTypes = ['USD', 'EUR', 'JPY'];
        $transmissionTypes = ['automatic', 'manual', 'semi-automatic'];

        $imagesList = [
            ['images/car/01.jpg', 'images/car/02.jpg'],
            ['images/car/03.jpg', 'images/car/04.jpg'],
            ['images/car/05.jpg', 'images/car/06.jpg'],
        ];
        $videosList = [
            ['videos/car/01.mp4'],
            ['videos/car/02.mp4'],
            [],
        ];

        // Generate 10 cars
        for ($i = 0; $i < 10; $i++) {
            Car::create([
                'title' => $titles[array_rand($titles)],
                'year' => $years[array_rand($years)],
                'make' => $makes[array_rand($makes)],
                'body_type' => $bodyTypes[array_rand($bodyTypes)],
                'car_condition' => $carConditions[array_rand($carConditions)],
                'car_color' => $carColors[array_rand($carColors)],
                'car_documents' => $documents[array_rand($documents)],
                'car_inside_color' => $carInsideColors[array_rand($carInsideColors)],
                'VIN_number' => strtoupper(bin2hex(random_bytes(8))),
                'location' => [
                    'city' => 'Sample City',
                    'state' => 'Sample State',
                    'country' => 'Sample Country'
                ],
                'model' => $models[array_rand($models)],
                'transmission_type' => TransmissionType::cases()[array_rand(TransmissionType::cases())]->value,
                'currency_type' => $currencyTypes[array_rand($currencyTypes)],
                'regular_price' => rand(10000, 50000),
                'sale_price' => rand(5000, 9000),
                'request_price_status' => (bool)rand(0, 1),
                'request_price' => rand(1000, 4000),
                'images' => $imagesList[array_rand($imagesList)],
                'videos' => $videosList[array_rand($videosList)],
            ]);
        }
    }
}

