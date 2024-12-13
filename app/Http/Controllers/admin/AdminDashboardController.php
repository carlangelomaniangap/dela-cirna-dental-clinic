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
    
        $approvedAppointments = Calendar::where('status', 'Approved')->whereDate('appointmentdate', Carbon::now('Asia/Manila'))->count();
    
        $pendingAppointments = Calendar::where('status', 'Pending')->whereDate('appointmentdate', Carbon::now('Asia/Manila'))->count();
    
        $todayAppointments = Calendar::whereDate('appointmentdate', Carbon::now('Asia/Manila'))->orderBy('appointmenttime')->get();

        $showUserWelcome = $request->session()->get('showUserWelcome', false);
    
        if ($showUserWelcome) {
            $request->session()->forget('showUserWelcome');
        }
    
        $users = User::where('id', $user->id)->where('usertype', 'admin')->get();

        $viewChoice = $request->input('view', 'week');
        if ($viewChoice == 'week') {
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();
            $approvedAppointments = Calendar::where('status', 'Approved')->whereBetween('appointmentdate', [$startOfWeek, $endOfWeek])->count();
            $pendingAppointments = Calendar::where('status', 'Pending')->whereBetween('appointmentdate', [$startOfWeek, $endOfWeek])->count();
            $completedAppointments = Calendar::where('status', 'Completed')->whereBetween('appointmentdate', [$startOfWeek, $endOfWeek])->count();
            $cancelledPendingAppointments = Calendar::where('status', 'PendingCancelled')->whereBetween('appointmentdate', [$startOfWeek, $endOfWeek])->count();
            $cancelledApprovedAppointments = Calendar::where('status', 'ApprovedCancelled')->whereBetween('appointmentdate', [$startOfWeek, $endOfWeek])->count();
        } elseif ($viewChoice == 'month') {
            $approvedAppointments = Calendar::where('status', 'Approved')->whereMonth('appointmentdate', Carbon::now()->month)->count();
            $pendingAppointments = Calendar::where('status', 'Pending')->whereMonth('appointmentdate', Carbon::now()->month)->count();
            $completedAppointments = Calendar::where('status', 'Completed')->whereMonth('appointmentdate', Carbon::now()->month)->count();
            $cancelledPendingAppointments = Calendar::where('status', 'PendingCancelled')->whereMonth('appointmentdate', Carbon::now()->month)->count();
            $cancelledApprovedAppointments = Calendar::where('status', 'ApprovedCancelled')->whereMonth('appointmentdate', Carbon::now()->month)->count();
        } elseif ($viewChoice == 'year') {
            $approvedAppointments = Calendar::where('status', 'Approved')->whereYear('appointmentdate', Carbon::now()->year)->count();
            $pendingAppointments = Calendar::where('status', 'Pending')->whereYear('appointmentdate', Carbon::now()->year)->count();
            $completedAppointments = Calendar::where('status', 'Completed')->whereYear('appointmentdate', Carbon::now()->year)->count();
            $cancelledPendingAppointments = Calendar::where('status', 'PendingCancelled')->whereYear('appointmentdate', Carbon::now()->year)->count();
            $cancelledApprovedAppointments = Calendar::where('status', 'ApprovedCancelled')->whereYear('appointmentdate', Carbon::now()->year)->count();
        } else {
            // Default to this week's data if the view is not recognized
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();
            $approvedAppointments = Calendar::where('status', 'Approved')->whereBetween('appointmentdate', [$startOfWeek, $endOfWeek])->count();
            $pendingAppointments = Calendar::where('status', 'Pending')->whereBetween('appointmentdate', [$startOfWeek, $endOfWeek])->count();
            $completedAppointments = Calendar::where('status', 'Completed')->whereBetween('appointmentdate', [$startOfWeek, $endOfWeek])->count();
            $cancelledPendingAppointments = Calendar::where('status', 'PendingCancelled')->whereBetween('appointmentdate', [$startOfWeek, $endOfWeek])->count();
            $cancelledApprovedAppointments = Calendar::where('status', 'ApprovedCancelled')->whereBetween('appointmentdate', [$startOfWeek, $endOfWeek])->count();
        }
    
        return view('admin.dashboard', compact('clinicUsers', 'patientCount', 'recentPatientCount',  'showUserWelcome', 'pendingAppointments', 'approvedAppointments', 'completedAppointments', 'cancelledPendingAppointments', 'cancelledApprovedAppointments', 'todayAppointments', 'viewChoice', 'users'));
    }
    
}