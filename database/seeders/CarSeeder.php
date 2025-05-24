<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Car;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $imageFiles = File::files(public_path('images/car'));
        $imagePaths = array_map(function ($file) {
            return 'images/car/' . $file->getFilename();
        }, $imageFiles);

        $makes = ['Toyota', 'Ford', 'Chevrolet', 'Honda', 'BMW', 'Audi', 'Nissan', 'Ferrari', 'Bugati'];
        $models = ['Corolla', 'Civic', 'Accord', 'Camry', 'Mustang', 'Altima', 'X5', '4Ruuner'];

        for ($i = 0; $i < 20; $i++) {
            $make = $makes[array_rand($makes)];
            $model = $models[array_rand($models)];
            $year = rand(2000, 2024);
            $regularPrice = rand(5000, 30000);
            $salePrice = rand(4000, $regularPrice);

            $numImages = rand(1, 5);
            $images = array_rand($imagePaths, min($numImages, count($imagePaths)));
            $images = is_array($images) ? array_map(fn($i) => $imagePaths[$i], $images) : [$imagePaths[$images]];

            Car::create([
                'title' => "$year $make $model",
                'year' => $year,
                'make' => $make,
                'location' => json_encode(['city' => 'Sample City', 'state' => 'CA']),
                'model' => $model,
                'VIN_number' => strtoupper(Str::random(17)),
                'regular_price' => $regularPrice,
                'sale_price' => $salePrice,
                'request_price_status' => (bool)rand(0, 1),
                'request_price' => rand(4000, 50000),
                'images' => json_encode($images),
            ]);
        }
    }
}
