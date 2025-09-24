<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Car::with(['user', 'auctions']);

        // Apply search filter if provided
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('make', 'like', "%$search%")
                    ->orWhere('model', 'like', "%$search%")
                    ->orWhere('year', 'like', "%$search%")
                    ->orWhere('color', 'like', "%$search%");
            });
        }

        // Apply type filter if provided
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Apply status filter if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Apply user filter if provided
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Order by newest first
        $query->orderBy('created_at', 'desc');

        $cars = $query->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $cars
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        
        $validator = Validator::make($request->all(), [
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:50',
            'mileage' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:sale,rent,auction',
            'transmission' => 'required|in:manual,automatic',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $carData = $request->all();
        $carData['user_id'] = $user->id;
        
        $car = Car::create($carData);

        return response()->json([
            'success' => true,
            'message' => 'Car created successfully',
            'data' => $car
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::with(['user', 'auctions', 'offers.user'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $car
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = $request->user();
        $car = Car::findOrFail($id);

        // Check if user owns this car
        if ($car->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to update this car'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'make' => 'sometimes|required|string|max:255',
            'model' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'sometimes|required|string|max:50',
            'mileage' => 'sometimes|required|integer|min:0',
            'price' => 'sometimes|required|numeric|min:0',
            'type' => 'sometimes|required|in:sale,rent,auction',
            'transmission' => 'sometimes|required|in:manual,automatic',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $car->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Car updated successfully',
            'data' => $car->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = $request->user();
        $car = Car::findOrFail($id);

        // Check if user owns this car
        if ($car->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to delete this car'
            ], 403);
        }

        $car->delete();

        return response()->json([
            'success' => true,
            'message' => 'Car deleted successfully'
        ]);
    }

    /**
     * Toggle car promotion status
     */
    public function togglePromoted(Request $request, $id)
    {
        $user = $request->user();
        $car = Car::findOrFail($id);

        // Check if user owns this car
        if ($car->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized to toggle promotion for this car'
            ], 403);
        }

        // Check if user can promote (not restricted or blocked)
        if (!$user->bargains->first()->canPromote()) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is restricted or blocked. Cannot promote cars.'
            ], 403);
        }

        // Toggle promoted status
        $car->is_promoted = !$car->is_promoted;
        $car->save();

        $message = $car->is_promoted ? 'Car promoted successfully' : 'Car promotion removed';

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $car->fresh()
        ]);
    }

    /**
     * Get offers for a specific car
     */
    public function getOffers(string $id)
    {
        $car = Car::findOrFail($id);
        
        $offers = Offer::where('car_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => [
                'car' => $car,
                'offers' => $offers
            ]
        ]);
    }
}