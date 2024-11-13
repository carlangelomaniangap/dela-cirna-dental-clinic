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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|string|min:8',
            'gender' => 'required|string',
            'birthday' => 'required|date',
            'age' => 'required|integer',
            'address' => 'required|string',
            'phone' => 'required|string|regex:/^0[0-9]{10}$/',
        ]);

        $request->file('logo')->move(public_path('logos'), $request->file('logo')->getClientOriginalName());

        // Create the clinic
        $dentalclinic = DentalClinic::create([
            'logo' => $request->file('logo')->getClientOriginalName(),
            'dentalclinicname' => $request->dentalclinicname,
            'status' => 'pending',
        ]);

        // Create the admin user associated with the clinic
        $admin = User::create([
            'dentalclinic_id' => $dentalclinic->id, // Associate with the newly created clinic
            'usertype' => 'admin',
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'age' => $request->age,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        Auth::login($admin);

        return redirect()->route('admin.dashboard')->with('success', 'Clinic and Admin created successfully!');
    }

    public function approve($id){

        $dentalclinic = DentalClinic::findOrFail($id);

        // Check if the dental clinic is already approved
        if ($dentalclinic->status === 'approved') {
            return redirect()->route('superadmin.dashboard')->with('status', 'This dental clinic is already approved.');
        }

        // Change the status to approved
        $dentalclinic->status = 'approved';
        $dentalclinic->save();

        // Redirect back to the dashboard
        return redirect()->route('superadmin.dashboard')->with('status', $dentalclinic->dentalclinicname . ' has been approved successfully.');
    }
}
