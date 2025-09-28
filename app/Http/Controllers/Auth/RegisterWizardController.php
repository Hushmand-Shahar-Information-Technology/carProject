<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SellerProfile;
use App\Models\Bargain;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;

class RegisterWizardController extends Controller
{
    /**
     * Display the registration wizard view.
     */
    public function show(Request $request)
    {
        $type = $request->query('type');
        
        // Validate type parameter
        if ($type && !in_array($type, ['seller', 'seeker'])) {
            $type = null;
        }
        
        return view('auth.register', compact('type'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        // Determine role from request
        $role = $request->input('role');
        
        if (!in_array($role, ['car_seller', 'car_seeker'])) {
            return response()->json([
                'errors' => ['role' => ['Invalid role selected.']]
            ], 422);
        }

        // Validate based on role
        if ($role === 'car_seller') {
            $validator = Validator::make($request->all(), [
                'username' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Password::defaults()],
                'profile_image' => ['nullable', 'image', 'max:5120'], // 5MB
            ], [
                'profile_image.max' => 'The profile image must not exceed 5MB.',
                'profile_image.image' => 'The profile image must be an image file.',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'full_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:20'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Create user
            $userData = [
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $role,
            ];

            // Add name based on role
            if ($role === 'car_seller') {
                $userData['name'] = $request->username;
            } else {
                $userData['name'] = $request->full_name;
            }

            $user = User::create($userData);
            Log::info('User created: ' . $user->id);

            // Create profile based on role
            if ($role === 'car_seller') {
                $profileImagePath = null;
                if ($request->hasFile('profile_image')) {
                    $profileImagePath = $request->file('profile_image')->store('profile_images', 'public');
                }

                // Auto-generate registration number
                $registrationNumber = 'REG' . date('Ymd') . strtoupper(substr(uniqid(), -6));

                $sellerProfile = SellerProfile::create([
                    'user_id' => $user->id,
                    'username' => $request->username,
                    'profile_image' => $profileImagePath,
                    'address' => $request->address,
                    'registration_number' => $registrationNumber,
                ]);
                Log::info('Seller profile created: ' . $sellerProfile->id);

                // Create initial bargain record for the seller
                $bargain = Bargain::create([
                    'seller_id' => $user->id,
                    'status' => 'open',
                ]);
                Log::info('Bargain created: ' . $bargain->id);
            }

            // Fire registered event
            event(new Registered($user));

            // Log the user in
            Auth::login($user);

            return response()->json([
                'success' => true,
                'redirect' => route('dashboard'),
                'message' => 'Registration successful! Welcome to our platform.'
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Registration error: ' . $e->getMessage());
            Log::error('Registration error trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'errors' => ['general' => ['An error occurred during registration. Please try again.']]
            ], 422);
        }
    }
}