<?php

namespace App\Console\Commands;

use App\Models\Auction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EndExpiredAuctions extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'auctions:end-expired';

    /**
     * The console command description.
     */
    protected $description = 'End all expired auctions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('[' . now()->toDateTimeString() . '] Checking for expired auctions...');

        // Get expired auctions that are still marked as active
        $expiredAuctions = Auction::where('status', 'active')
            ->whereNotNull('end_at')
            ->where('end_at', '<=', now())
            ->get();

        if ($expiredAuctions->isEmpty()) {
            $this->info('[' . now()->toDateTimeString() . '] No expired auctions found.');
            return 0;
        }

        $count = $expiredAuctions->count();
        $this->info("Found {$count} expired auction(s).");

        // Update the auctions
        $updated = Auction::where('status', 'active')
            ->whereNotNull('end_at')
            ->where('end_at', '<=', now())
            ->update(['status' => 'ended', 'updated_at' => now()]);

        $this->info("Successfully ended {$updated} auction(s).");
        
        // Log the action
        Log::info("Ended {$updated} expired auctions", [
            'command' => 'auctions:end-expired',
            'timestamp' => now()->toDateTimeString(),
            'auction_ids' => $expiredAuctions->pluck('id')->toArray()
        ]);

        // Display details of ended auctions
        $this->table(
            ['ID', 'Car ID', 'Starting Price', 'End Date', 'Status'],
            $expiredAuctions->map(function ($auction) {
                return [
                    $auction->id,
                    $auction->car_id,
                    '$' . number_format($auction->starting_price, 2),
                    $auction->end_at ? $auction->end_at->format('Y-m-d H:i:s') : 'N/A',
                    'ended'
                ];
            })
        );

        return 0;
    }
}