<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('cars')->insert([
            [
                'title' => 'Toyota Corolla 2020',
                'year' => '2020',
                'make' => 'Toyota',
                'model' => 'Corolla',
                'VIN_number' => 'JTDBL40E399123456',
                'regular_price' => 15000.00,
                'sale_price' => 13999.99,
                'request_price_status' => false,
                'request_price' => null,
                'location' => json_encode(['city' => 'Kabul', 'country' => 'Afghanistan']),
                'images' => json_encode(['image1.jpg', 'image2.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Honda Civic 2021',
                'year' => '2021',
                'make' => 'Honda',
                'model' => 'Civic',
                'VIN_number' => '2HGFC2F69MH123456',
                'regular_price' => 18000.00,
                'sale_price' => 17500.00,
                'request_price_status' => true,
                'request_price' => 17000.00,
                'location' => json_encode(['city' => 'Herat', 'country' => 'Afghanistan']),
                'images' => json_encode(['civic_front.jpg', 'civic_back.jpg']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
