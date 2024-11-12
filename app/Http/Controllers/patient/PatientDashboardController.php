<?php

namespace App\Http\Controllers\patient;
use App\Http\Controllers\Controller;
use App\Models\DentalClinic;
use App\Models\Schedule;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientDashboardController extends Controller
{
    public function index(Request $request){

        $dentalclinicId = Auth::user()->dentalclinic_id;

        $treatments = Treatment::where('dentalclinic_id', $dentalclinicId)->get();

        $dentalclinic = DentalClinic::find($dentalclinicId);

        $users = User::where('dentalclinic_id', $dentalclinicId)->where('usertype', 'admin')->get();

        $schedule = Schedule::where('dentalclinic_id', $dentalclinicId)->first();

        $showUserWelcome = $request->session()->get('showUserWelcome', false);
    
        // Clear the session variable if it exists
        if ($showUserWelcome) {
            $request->session()->forget('showUserWelcome');
        }

        return view('dentistrystudent.dashboard', compact('treatments', 'dentalclinic', 'users', 'schedule', 'showUserWelcome'));
    }

}