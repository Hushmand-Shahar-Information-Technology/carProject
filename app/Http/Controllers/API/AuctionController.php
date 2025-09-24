<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Auction::with(['car', 'car.user']);

        // Filter by car ID if provided
        if ($request->has('car_id') && $request->car_id) {
            $query->where('car_id', $request->car_id);
        }

        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by auction type if provided
        if ($request->has('auction_type') && $request->auction_type) {
            $query->where('auction_type', $request->auction_type);
        }

        $auctions = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $auctions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|exists:cars,id',
            'starting_price' => 'required|numeric|min:0',
            'auction_type' => 'required|in:fixed,timed',
            'duration_days' => 'required_if:auction_type,fixed|integer|min:1|max:30',
            'end_at' => 'required_if:auction_type,timed|date|after:now',
            'message' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if user owns the car
        $car = Car::findOrFail($request->car_id);
        if (Auth::check() && $car->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You can only create auctions for your own cars.'
            ], 403);
        }

        // Check if there's already an active auction for this car
        $existingActiveAuction = Auction::where('car_id', $request->car_id)
            ->where('status', 'active')
            ->exists();

        if ($existingActiveAuction) {
            return response()->json([
                'success' => false,
                'message' => 'This car already has an active auction. You cannot create another auction until the current one expires or is ended.'
            ], 400);
        }

        // Prepare data for auction creation
        $data = $request->only(['car_id', 'starting_price', 'auction_type', 'message']);
        
        if ($request->auction_type === 'fixed') {
            $data['end_at'] = now()->addDays((int) $request->duration_days);
        } else {
            $data['end_at'] = $request->end_at;
        }
        
        $data['status'] = 'active';

        try {
            $auction = Auction::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Auction created successfully!',
                'data' => $auction->load(['car', 'car.user'])
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error creating auction: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the auction.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $auction = Auction::with(['car', 'car.user', 'car.offers'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $auction
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $auction = Auction::findOrFail($id);

        // Check if user owns the car
        if (Auth::check() && $auction->car->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You can only update auctions for your own cars.'
            ], 403);
        }

        // Cannot update ended auctions
        if ($auction->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot update an auction that is not active.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'starting_price' => 'sometimes|numeric|min:0',
            'message' => 'nullable|string|max:1000',
            'end_at' => 'sometimes|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $auction->update($request->only(['starting_price', 'message', 'end_at']));

        return response()->json([
            'success' => true,
            'message' => 'Auction updated successfully',
            'data' => $auction->fresh()->load(['car', 'car.user'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $auction = Auction::findOrFail($id);

        // Check if user owns the car
        if (Auth::check() && $auction->car->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You can only delete auctions for your own cars.'
            ], 403);
        }

        // Cannot delete active auctions
        if ($auction->status === 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete an active auction. Please end it first.'
            ], 400);
        }

        $auction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Auction deleted successfully'
        ]);
    }

    /**
     * End an auction early
     */
    public function endAuction(Request $request, $id)
    {
        try {
            $auction = Auction::with('car')->findOrFail($id);
            
            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to end an auction.'
                ], 401);
            }
            
            // Check if user owns the car
            if ($auction->car->user_id !== Auth::id()) {
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
                'message' => 'Auction ended successfully.',
                'data' => $auction->fresh()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error ending auction: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while ending the auction.'
            ], 500);
        }
    }
}