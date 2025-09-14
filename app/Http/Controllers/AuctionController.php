<?php

namespace App\Http\Controllers;

use App\Models\Auction;
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

        // Create auction
        if ($request->auction_type === 'fixed') {
            $data['end_at'] = now()->addDays((int) $request->duration_days);
        }
        $auction = Auction::create($data);

        return redirect()->back()->with('success', 'Auction created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auction $auction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auction $auction)
    {
        //
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
