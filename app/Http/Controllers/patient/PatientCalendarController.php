<?php

namespace App\Http\Controllers\patient;
use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\User;
use App\Notifications\AppointmentNotifications;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientCalendarController extends Controller
{
    public function getBookedTimes(Request $request){
        $date = $request->query('date');
        $bookedTimes = Calendar::whereDate('appointmentdate', $date)
            ->pluck('appointmenttime')
            ->toArray();

        return response()->json($bookedTimes);
    }

    public function index(){
        $calendars = Calendar::all();
        return view('patient.calendar.calendar', compact('calendars'));
    }

    public function createCalendar($userId){
        $users = User::findOrFail($userId);
        return view('patient.appointment.appointment', compact('users'));
    }

    public function storeCalendar(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'appointmentdate' => 'required|date',
            'appointmenttime' => 'required',
            'concern' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'birthday' => 'required|date',
            'age' => 'required|string',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^0[0-9]{10}$/',
            'email' => 'required|string|lowercase|email|max:255',
            'medicalhistory' => 'nullable|string',
            'emergencycontactname' => 'required|string|max:255',
            'emergencycontactrelation' => 'required|string',
            'emergencycontactphone' => 'required|string|regex:/^0[0-9]{10}$/',
            'relationname' => 'nullable|string|max:255',
            'relation' => 'nullable|string',
        ]);

        $pendingAppointmentsCount = Calendar::where('user_id', $request->input('user_id'))
            ->where('approved', 'Pending')
            ->count();

        if ($pendingAppointmentsCount >= 3) {
            return redirect()->back()->withErrors([
                'appointment_limit' => 'You have reached the limit of 3 pending appointments. Please wait until one is approved or canceled before booking another.',
            ]);
        }

        $existingAppointment = Calendar::where([
            'appointmentdate' => $request->input('appointmentdate'),
            'appointmenttime' => $request->input('appointmenttime'),
        ])->first();

        if ($existingAppointment) {
            return redirect()->back()->withErrors(['appointmenttime' => 'This time is already booked. Please select a different time.']);
        }

        $calendar = Calendar::create([
            'user_id' => $request->input('user_id'),
            'appointmentdate' => $request->input('appointmentdate'),
            'appointmenttime' => $request->input('appointmenttime'),
            'concern' => $request->input('concern'),
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            'birthday' => $request->input('birthday'),
            'age' => $request->input('age'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'medicalhistory' => $request->input('medicalhistory'),
            'emergencycontactname' => $request->input('emergencycontactname'),
            'emergencycontactrelation' => $request->input('emergencycontactrelation'),
            'emergencycontactphone' => $request->input('emergencycontactphone'),
            'relationname' => $request->input('relationname'),
            'relation' => $request->input('relation'),
            'approved' => 'Pending',
        ]);

        $appointmentDate = Carbon::parse($calendar->appointmentdate)->format('F j, Y');
        $appointmentTime = Carbon::parse($calendar->appointmenttime)->format('h:i A');
        $message = "{$calendar->name} has scheduled a new appointment for {$appointmentDate} at {$appointmentTime}.";

        $admin = User::where('usertype', 'admin')->first();
        if ($admin) {
            $admin->notify(new AppointmentNotifications($calendar, $message));
        }

        return redirect()->route('patient.appointment')->with('success', 'Appointment added successfully!');
    }

    public function viewDetails($id){
        $calendar = Calendar::findOrFail($id);

        if (Auth::user()->usertype !== 'admin' && Auth::id() !== $calendar->user_id) {
            return redirect()->route('home');
        }

        return view('patient.calendar.viewDetails', compact('calendar'));
    }
}
