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
        $this->info('Checking for expired auctions...');

        $expiredAuctions = Auction::where('status', 'active')
            ->whereNotNull('end_at')
            ->where('end_at', '<=', now())
            ->get();

        if ($expiredAuctions->isEmpty()) {
            $this->info('No expired auctions found.');
            return;
        }

        $count = $expiredAuctions->count();
        $this->info("Found {$count} expired auction(s).");

        // Update the auctions
        $updated = Auction::where('status', 'active')
            ->whereNotNull('end_at')
            ->where('end_at', '<=', now())
            ->update(['status' => 'ended']);

        $this->info("Successfully ended {$updated} auction(s).");
        
        // Log the action
        Log::info("Ended {$updated} expired auctions", [
            'command' => 'auctions:end-expired',
            'timestamp' => now()->toDateTimeString(),
            'auction_ids' => $expiredAuctions->pluck('id')->toArray()
        ]);

        // Display details of ended auctions
        if ($this->option('verbose')) {
            $this->table(
                ['ID', 'Car ID', 'Starting Price', 'End Date', 'Status'],
                $expiredAuctions->map(function ($auction) {
                    return [
                        $auction->id,
                        $auction->car_id,
                        '$' . number_format($auction->starting_price, 2),
                        $auction->end_at->format('Y-m-d H:i:s'),
                        'ended'
                    ];
                })
            );
        }
    }
}