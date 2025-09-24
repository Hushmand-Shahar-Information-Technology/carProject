<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Bargain;
use App\Models\Car;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request)
    {
        $user = $request->user()->load(['bargains', 'cars']);
        
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update($request->only(['name', 'email']));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $user->fresh()
        ]);
    }

    /**
     * Change the user's password.
     */
    public function changePassword(Request $request)
    {
        $user = $request->user();
        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 422);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }

    /**
     * Get dashboard statistics for the user.
     */
    public function dashboardStats(Request $request)
    {
        $user = $request->user();
        
        // Get user's bargains count
        $bargainsCount = $user->bargains()->count();
        
        // Get user's cars count
        $carsCount = $user->cars()->count();
        
        // Get active auctions count
        $activeAuctionsCount = Car::whereHas('auctions', function ($query) {
            $query->where('status', 'active');
        })->count();
        
        // Get recent notifications count
        $notificationsCount = $user->notifications()->where('read_at', null)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'bargains_count' => $bargainsCount,
                'cars_count' => $carsCount,
                'active_auctions_count' => $activeAuctionsCount,
                'unread_notifications_count' => $notificationsCount
            ]
        ]);
    }
}