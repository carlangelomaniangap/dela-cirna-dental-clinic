<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\DentalClinic;

class SuperAdminDashboardController extends Controller
{
    public function index(){

        $dentalclinics = DentalClinic::with('admin')->get();
        
        return view('superadmin.dashboard', compact('dentalclinics'));
    }
}