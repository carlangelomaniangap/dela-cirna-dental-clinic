<?php

namespace App\Http\Controllers\patient;
use App\Http\Controllers\Controller;
use App\Models\Calendar;
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

        $userId = auth()->id();

        // Determine the appointment type filter
        $filter = $request->get('filter', 'upcoming'); // Default to 'upcoming'

        // Retrieve appointments based on the selected filter
        if ($filter == 'past') {
            // Get past appointments
            $calendars = Calendar::where('user_id', $userId)
                                 ->where('appointmentdate', '<', now()->toDateString())
                                 ->orderBy('appointmentdate', 'desc')
                                 ->get();
        } else {
            // Get upcoming appointments
            $calendars = Calendar::where('user_id', $userId)
                                 ->where('appointmentdate', '>=', now()->toDateString())
                                 ->orderBy('appointmentdate')
                                 ->get();
        }

        return view('patient.dashboard', compact('treatments', 'dentalclinic', 'users', 'schedule', 'showUserWelcome', 'calendars', 'filter'));
    }

}