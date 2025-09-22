<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Requests\AuctionRequest;
use Illuminate\Support\Facades\Log;

class AuctionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(AuctionRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();

        // Check if there's already an active auction for this car
        $existingActiveAuction = Auction::where('car_id', $data['car_id'])
            ->where('status', 'active')
            ->exists();

        if ($existingActiveAuction) {
            return redirect()->back()->with('error', 'This car already has an active auction. You cannot create another auction until the current one expires or is ended.');
        }

        // Create auction
        if ($request->auction_type === 'fixed') {
            $data['end_at'] = now()->addDays((int) $request->duration_days);
        }
        $auction = Auction::create($data);

        return redirect()->back()->with('success', 'Auction created successfully!');
    }

    /**
     * End an auction early
     */
    public function endAuction(Request $request, $id)
    {
        try {
            $auction = Auction::with('car')->findOrFail($id);
            
            // Check if user is authenticated
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to end an auction.'
                ], 401);
            }
            
            // Check if user owns the car
            if ($auction->car->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only end your own auctions.'
                ], 403);
            }
            
            // Check if auction is active
            if ($auction->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'This auction is already ended or not active.'
                ], 400);
            }
            
            // End the auction
            $auction->update([
                'status' => 'ended',
                'end_at' => now() // Set actual end time
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Auction ended successfully.'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error ending auction: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while ending the auction.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auction $auction)
    {
        //
    }
}