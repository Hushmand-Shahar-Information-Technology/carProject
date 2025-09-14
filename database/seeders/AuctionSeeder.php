<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Auction;
use App\Models\Car;

class AuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some cars to create auctions for
        $cars = Car::limit(10)->get();
        
        if ($cars->count() > 0) {
            foreach ($cars as $index => $car) {
                // Create different types of auctions
                $auctionTypes = ['fixed', 'open'];
                $statuses = ['active', 'active', 'active', 'ended']; // More active than ended
                
                $auctionType = $auctionTypes[array_rand($auctionTypes)];
                $status = $statuses[array_rand($statuses)];
                
                $auctionData = [
                    'car_id' => $car->id,
                    'starting_price' => $car->regular_price * 0.8, // 80% of regular price
                    'auction_type' => $auctionType,
                    'status' => $status,
                    'message' => 'Auction for ' . $car->title,
                ];
                
                // Add end date for fixed auctions
                if ($auctionType === 'fixed') {
                    $durationDays = rand(1, 30); // Random duration between 1-30 days
                    $auctionData['duration_days'] = $durationDays;
                    
                    if ($status === 'active') {
                        $auctionData['end_at'] = now()->addDays($durationDays);
                    } else {
                        $auctionData['end_at'] = now()->subDays(rand(1, 10)); // Ended recently
                    }
                }
                
                Auction::create($auctionData);
            }
        }
    }
}
