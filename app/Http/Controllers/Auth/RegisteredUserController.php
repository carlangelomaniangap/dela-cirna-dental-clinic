<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DentalClinic;
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
        // Retrieve dental clinics
        $dentalclinics = DentalClinic::all();
        return view('auth.register', compact('dentalclinics'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'dentalclinic_id' => ['required', 'exists:dentalclinics,id'],
            'usertype' => ['required', 'string', 'in:patient,dentistrystudent'], // Add validation for usertype
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender' => ['required', 'string'],
            'birthday' => ['required', 'date'],
            'age' => ['required', 'integer'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'regex:/^0[0-9]{10}$/'],
        ]);

        $user = User::create([
            'dentalclinic_id' => $request->dentalclinic_id,
            'usertype' => $request->usertype, // Store usertype
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
            case 'admin':
                return redirect()->route('admin.dashboard');
                break;
            case 'patient':
                return redirect()->route('patient.dashboard');
                break;
            case 'dentistrystudent':
                return redirect()->route('dentistrystudent.dashboard');
                break;
            default:
                return redirect(RouteServiceProvider::HOME);
        }
    }
}
