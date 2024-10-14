<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\DentalClinic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DentalClinicController extends Controller
{
    public function create(){
        
        return view('dentalclinics.create');
    }

    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dentalclinicname' => 'required|string|max:255',
            'admin_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'admin_password' => 'required|string|min:8',
        ]);

        $request->file('logo')->move(public_path('logos'), $request->file('logo')->getClientOriginalName());

        // Create the clinic
        $dentalclinic = DentalClinic::create([
            'logo' => $request->file('logo')->getClientOriginalName(),
            'dentalclinicname' => $request->dentalclinicname,
        ]);

        // Create the admin user associated with the clinic
        $admin = User::create([
            'dentalclinic_id' => $dentalclinic->id, // Associate with the newly created clinic
            'usertype' => 'admin',
            'name' => $request->admin_name,
            'email' => $request->email,
            'password' => Hash::make($request->admin_password),
        ]);

        Auth::login($admin);

        return redirect()->route('admin.dashboard')->with('success', 'Clinic and Admin created successfully!');
    }
}
