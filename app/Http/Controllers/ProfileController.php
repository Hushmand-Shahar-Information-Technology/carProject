<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show()
    {
        $profile = Auth::user();
        // Load cars with offers count for better performance
        $profile->load(['cars.offers']);

        // Get bargains associated with the user via the direct relationship
        // Also load the cars relationship for each bargain with offers count
        $bargains = $profile->bargains()->with(['promotions', 'cars.offers'])->get();

        // Add offers count to each bargain
        foreach ($bargains as $bargain) {
            $bargain->total_offers = $bargain->cars->sum(function ($car) {
                return $car->offers->count();
            });
        }

        return view('profile.profile', compact('profile', 'bargains'));
    }

    /**
     * Get cars for a specific bargain
     */
    public function getBargainCars(Request $request, $bargainId)
    {
        $profile = Auth::user();
        $bargain = $profile->bargains()->with('cars.offers')->find($bargainId);

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
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();
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
        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
