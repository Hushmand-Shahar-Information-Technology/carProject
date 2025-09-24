<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Promotion::with(['promotable']);

        // Filter by promotable type if provided
        if ($request->has('promotable_type') && $request->promotable_type) {
            $query->where('promotable_type', $request->promotable_type);
        }

        // Filter by active promotions
        if ($request->has('active') && $request->active) {
            $query->where(function ($q) {
                $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
            });
        }

        $promotions = $query->orderBy('created_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $promotions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'promotable_type' => 'required|in:App\Models\Car',
            'promotable_id' => 'required|integer',
            'starts_at' => 'nullable|date',
            'ends_at' => 'required|date|after:starts_at',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify the promotable entity exists and user has permission
        if ($request->promotable_type === 'App\Models\Car') {
            $car = Car::findOrFail($request->promotable_id);
            
            // Check if user owns the car
            if (Auth::check() && $car->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can only promote your own cars.'
                ], 403);
            }
        }

        $promotion = Promotion::create([
            'promotable_type' => $request->promotable_type,
            'promotable_id' => $request->promotable_id,
            'starts_at' => $request->starts_at ?? now(),
            'ends_at' => $request->ends_at,
            'created_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Promotion created successfully',
            'data' => $promotion->load(['promotable'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $promotion = Promotion::with(['promotable'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $promotion
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $promotion = Promotion::findOrFail($id);

        // Check if user created this promotion
        if (Auth::check() && $promotion->created_by !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this promotion'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after:starts_at',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $promotion->update($request->only(['starts_at', 'ends_at']));

        return response()->json([
            'success' => true,
            'message' => 'Promotion updated successfully',
            'data' => $promotion->fresh()->load(['promotable'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promotion = Promotion::findOrFail($id);

        // Check if user created this promotion
        if (Auth::check() && $promotion->created_by !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this promotion'
            ], 403);
        }

        $promotion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Promotion deleted successfully'
        ]);
    }
}