<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address.',
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;

        // Check if email already exists in emails table
        $existingEmail = Email::where('email', $email)->first();
        if ($existingEmail) {
            return response()->json([
                'success' => false,
                'message' => 'This email is already subscribed to our newsletter.'
            ], 409);
        }

        // Check if user is logged in and update their subscription status
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->email === $email) {
                $user->update(['newsletter_subscribed' => true]);
            }
        }

        // Create new email subscription
        Email::create(['email' => $email]);

        return response()->json([
            'success' => true,
            'message' => 'You have successfully subscribed to our newsletter!'
        ]);
    }

    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ], 422);
        }

        $email = $request->email;

        // Remove from emails table
        Email::where('email', $email)->delete();

        // Update user subscription status if logged in
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->email === $email) {
                $user->update(['newsletter_subscribed' => false]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'You have successfully unsubscribed from our newsletter.'
        ]);
    }
}
