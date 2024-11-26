<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use App\Models\DentalClinic;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SuperAdminDashboardController extends Controller
{
    public function index(){
    
        $users = User::all();

        $dentalclinics = DentalClinic::all();
        
        $usersCount = $users->count();

        $dentalclinicsCount = $dentalclinics->count();

        $adminCount = $users->where('usertype', 'admin')->count();

        $dentistrystudentCount = $users->where('usertype', 'dentistrystudent')->count();
        
        return view('superadmin.dashboard', compact('users', 'usersCount', 'dentalclinicsCount', 'adminCount', 'dentistrystudentCount'));
    }
}