<?php

namespace App\Http\Controllers\patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientDashboardController extends Controller
{
    public function index(Request $request){

        $showUserWelcome = $request->session()->get('showUserWelcome', false);
    
        // Clear the session variable if it exists
        if ($showUserWelcome) {
            $request->session()->forget('showUserWelcome');
        }

        return view('patient.dashboard', compact('showUserWelcome'));
    }

}