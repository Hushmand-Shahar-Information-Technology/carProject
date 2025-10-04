<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Load cars with all necessary relationships for proper display
        $user->load([
            'cars.auctions',
            'cars.bargain',
            'bargains' // Load the bargains relationship
        ]);

        // Get the first active bargain if exists
        $activeBargain = $user->bargains->first();

        return view('profile.profile', compact('user', 'activeBargain'));
    }

    /**
     * Display the user's profile form.
     */
    public function showUser($id)
    {
        $user = User::findOrFail($id);

        // Load cars with all necessary relationships for proper display
        $user->load([
            'cars.auctions',
            'cars.bargain',
            'bargains' // Load the bargains relationship
        ]);

        // Get the first active bargain if exists
        $activeBargain = $user->bargains->first();

        return view('profile.profile', compact('user', 'activeBargain'));
    }
    /**
     * Set the profile mode (user or bargain) via AJAX
     */
    public function setProfileMode(Request $request): JsonResponse
    {
        $mode = $request->input('mode');
        $bargainId = $request->input('bargain_id');

        if ($mode === 'user') {
            session(['profile_mode' => 'user', 'active_bargain_id' => null]);
        } elseif ($mode === 'bargain' && $bargainId) {
            session(['profile_mode' => 'bargain', 'active_bargain_id' => $bargainId]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Get cars for a specific bargain
     */
    public function getBargainCars(Request $request, $bargainId)
    {
        $user = Auth::user();
        $bargain = $user->bargains()->with('cars.auctions')->find($bargainId);

        if (!$bargain) {
            return response()->json(['error' => 'Bargain not found'], 404);
        }

        return response()->json([
            'cars' => $bargain->cars,
            'bargain' => $bargain
        ]);
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Check if we're only updating the avatar
        $avatarOnly = $request->hasFile('avatar') && !$request->has('name') && !$request->has('email');

        // Validate the request
        $rules = [
            'phone' => ['nullable', 'string', 'max:255'], // Phone is always optional
            'avatar' => ['nullable', 'image', 'max:2048'], // Avatar is always optional
        ];

        // Add name and email validation only if they are being updated
        if ($request->has('name') || !$avatarOnly) {
            $rules['name'] = ['required', 'string', 'max:255'];
        }

        if ($request->has('email') || !$avatarOnly) {
            $rules['email'] = [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ];
        }

        $validated = $request->validate($rules);

        // Handle avatar upload if present
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists and is not the default
            if ($user->avatar && $user->avatar !== 'avatar.png') {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store the new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Update other fields if they are present
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }
        }

        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        $user->save();

        // Always return JSON response for our modal implementation
        return response()->json(['success' => true, 'message' => 'Profile updated successfully']);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
