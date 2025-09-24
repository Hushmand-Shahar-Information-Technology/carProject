<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticateApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check for API token in header
        $token = $request->header('Authorization');
        
        // If token is in Bearer format, extract it
        if ($token && strpos($token, 'Bearer ') === 0) {
            $token = substr($token, 7);
        }
        
        // If no token in header, check query parameter
        if (!$token) {
            $token = $request->query('api_token');
        }
        
        // If still no token, return unauthorized
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'API token not provided'
            ], 401);
        }
        
        // Find user with this token
        $user = User::where('api_token', $token)->first();
        
        // If no user found, return unauthorized
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API token'
            ], 401);
        }
        
        // Set the authenticated user
        Auth::login($user);
        
        return $next($request);
    }
}