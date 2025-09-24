<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Offer::with(['car', 'car.user']);

        // Filter by car ID if provided
        if ($request->has('car_id') && $request->car_id) {
            $query->where('car_id', $request->car_id);
        }

        // Filter by user ID if provided
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        $offers = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $offers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OfferRequest $request)
    {
        try {
            $offer = Offer::create([
                'name' => $request->mao_name,
                'phone' => $request->mao_phone,
                'email' => $request->mao_email,
                'price' => $request->mao_price,
                'car_id' => $request->mao_car_id,
                'remark' => $request->mao_comments,
                'user_id' => Auth::id(), // Associate with authenticated user if available
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Offer submitted successfully!',
                'data' => $offer->load(['car', 'car.user'])
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $offer = Offer::with(['car', 'car.user'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $offer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $offer = Offer::findOrFail($id);

        // Check if user owns this offer
        if (Auth::check() && $offer->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this offer'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|max:255',
            'price' => 'sometimes|numeric|min:0',
            'remark' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $offer->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Offer updated successfully',
            'data' => $offer->fresh()->load(['car', 'car.user'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $offer = Offer::findOrFail($id);

        // Check if user owns this offer
        if (Auth::check() && $offer->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this offer'
            ], 403);
        }

        $offer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Offer deleted successfully'
        ]);
    }
}