<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\DentalClinic;

class SuperAdminDentalClinicListController extends Controller
{
    public function index(){

        $dentalclinics = DentalClinic::with('admin')->get();
        
        return view('superadmin.dentalcliniclist.dentalcliniclist', compact('dentalclinics'));
    }

    public function approve($id){

        $dentalclinic = DentalClinic::findOrFail($id);

        // Check if the dental clinic is already approved
        if ($dentalclinic->status === 'approved') {
            return redirect()->route('superadmin.dentalcliniclist')->with('status', 'This dental clinic is already approved.');
        }

        // Change the status to approved
        $dentalclinic->status = 'approved';
        $dentalclinic->save();

        // Redirect back to the dashboard
        return redirect()->route('superadmin.dentalcliniclist')->with('status', $dentalclinic->dentalclinicname . ' has been approved successfully.');
    }
}