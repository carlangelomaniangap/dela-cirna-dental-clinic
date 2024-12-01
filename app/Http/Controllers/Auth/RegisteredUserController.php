<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'age' => $request->age,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        event(new Registered($user));

        Auth::login($user);

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
