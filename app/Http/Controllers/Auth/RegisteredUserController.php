<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patientlist;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $googleUser = session('google_user');

        if (!$googleUser) {
            // Redirect back if Google user data is missing
            return redirect()->route('auth.google.redirect')->with('error', 'Google authentication required.');
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender' => ['required', 'string'],
            'birthday' => ['required', 'date'],
            'age' => ['required', 'integer'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'regex:/^0[0-9]{10}$/'],
        ];

        // Validate the incoming request based on the defined rules
        $request->validate($rules);

        $user = User::create([
            'usertype' => 'patient',
            'name' => $googleUser['name'], // From Google
            'email' => $googleUser['email'], // From Google
            'email_verified_at' => $googleUser['email_verified_at'],
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'age' => $request->age,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        Patientlist::create([
            'users_id' => $user->id,
            'name' => $user->name,
            'gender' => $user->gender,
            'birthday' => $user->birthday,
            'age' => $user->age,
            'address' => $user->address,
            'phone' => $user->phone,
            'email' => $user->email,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Check if the user is verified
        if (!$user->hasVerifiedEmail()) {
            // Redirect to the email verification notice page
            return redirect()->route('verification.notice');
        }

        // Redirect based on usertype
        switch ($user->usertype) {
            case 'patient':
                return redirect()->route('patient.dashboard');
                break;
            default:
                return redirect(RouteServiceProvider::HOME);
        }
    }
}
