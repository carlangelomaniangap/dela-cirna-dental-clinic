<?php

namespace App\Http\Controllers\dentistrystudent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DentistryStudentDashboardController extends Controller
{
    public function index(Request $request){

        $showUserWelcome = $request->session()->get('showUserWelcome', false);
    
        // Clear the session variable if it exists
        if ($showUserWelcome) {
            $request->session()->forget('showUserWelcome');
        }

        return view('dentistrystudent.dashboard', compact('showUserWelcome'));
    }

}