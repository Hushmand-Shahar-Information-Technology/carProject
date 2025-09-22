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

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        // Load cars with all necessary relationships for proper display
        $user->load(['cars.auctions']);

        // Get bargains associated with the user via the direct relationship
        // Also load the cars relationship for each bargain with all necessary relationships
        $bargains = $user->bargains()->with(['promotions', 'cars.auctions'])->get();

        // Check if we're viewing a specific bargain profile
        // First check query parameter, then check session
        $bargainId = $request->query('bargain_id');

        // If no bargain_id in query parameter, check session
        if (!$bargainId) {
            $bargainId = session('active_bargain_id');
        }

        $activeBargain = null;

        if ($bargainId) {
            $activeBargain = $user->bargains()->with(['promotions', 'cars.auctions'])->find($bargainId);
            if ($activeBargain) {
                // Store in session to persist mode
                session(['profile_mode' => 'bargain', 'active_bargain_id' => $bargainId]);
            } else {
                // If bargain not found, clear session data
                session(['profile_mode' => 'user', 'active_bargain_id' => null]);
            }
        } else {
            // Ensure we're in user mode if no bargain is selected
            session(['profile_mode' => 'user', 'active_bargain_id' => null]);
        }

        return view('profile.profile', compact('user', 'bargains', 'activeBargain'));
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
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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