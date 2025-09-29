<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventBargainRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is currently in bargain mode
        if (session('profile_mode') === 'bargain' && session('active_bargain_id')) {
            // Get the active bargain
            $activeBargain = Auth::user()->bargains()->find(session('active_bargain_id'));

            // If user is in bargain mode, redirect them to profile with message
            if ($activeBargain) {
                return redirect()->route('user.profile', ['bargain_id' => $activeBargain->id])
                    ->with('swal_error', 'You are currently in bargain mode. To register a new bargain, please switch to user profile mode first.');
            }
        }

        return $next($request);
    }
}
