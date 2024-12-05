<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Calendar;
use App\Models\Schedule;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request){

        $user = Auth::user();
    
        $clinicUsers = User::where('usertype', ['patient'])->get();
        
        $patientCount = $clinicUsers->where('usertype', 'patient')->count();

        $recentPatientCount = User::where('usertype', 'patient')->whereDay('created_at', now()->day)->count();

        $approvedAppointments = Calendar::where('approved', 'Approved')->whereDate('appointmentdate', Carbon::now('Asia/Manila'))->count();
        
        $pendingAppointments = Calendar::where('approved', 'Pending')->whereDate('appointmentdate', Carbon::now('Asia/Manila'))->count();
        
        $todayAppointments = Calendar::whereDate('appointmentdate', Carbon::now('Asia/Manila'))->orderBy('appointmenttime')->get();
        
        $showUserWelcome = $request->session()->get('showUserWelcome', false);
    
        if ($showUserWelcome) {
            $request->session()->forget('showUserWelcome');
        }

        $users = User::where('id', $user->id)->where('usertype', 'admin')->get();

        return view('admin.dashboard', compact('clinicUsers', 'patientCount', 'recentPatientCount',  'showUserWelcome', 'pendingAppointments', 'approvedAppointments', 'todayAppointments', 'users'));
    }
}