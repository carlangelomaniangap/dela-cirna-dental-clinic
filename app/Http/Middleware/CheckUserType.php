<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $type
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {
        if (Auth::check()) {
            // Check if the authenticated user's usertype matches the required type
            if (Auth::user()->usertype === $type) {
                // If user is a patient, ensure email is verified
                if ($type === 'patient' && !Auth::user()->hasVerifiedEmail()) {
                    // Redirect to verification notice if the user is a patient and email is not verified
                    return redirect()->route('verification.notice');
                }

                // Allow the request to proceed if the user type and email verification are valid
                return $next($request);
            }
        }

        // Redirect to home route if usertype does not match or user is not authenticated
        return redirect()->route('home'); // Add a flash message if needed
    }
}
