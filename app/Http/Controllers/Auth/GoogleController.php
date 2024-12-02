<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Check if the user already exists
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            // Log in the user if they already exist
            Auth::login($existingUser);
            return redirect()->route('patient.dashboard');
        }

        // Store Google user data in session for pre-filling
        session([
            'google_user' => [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'email_verified_at' => now(),
            ]
        ]);

        // Redirect to the registration form
        return redirect()->route('register');
    }
}
