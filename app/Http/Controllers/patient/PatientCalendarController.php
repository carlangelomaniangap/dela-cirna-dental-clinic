<?php

namespace App\Http\Controllers\patient;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Calendar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientCalendarController extends Controller
{
    public function getBookedTimes(Request $request){

        $date = $request->query('date');

        // Fetch appointments for the given date
        $bookedTimes = Calendar::whereDate('appointmentdate', $date)
            ->pluck('appointmenttime')
            ->toArray();

        return response()->json($bookedTimes);
    }

    public function index(){

        $user = Auth::user();

        // Retrieve calendars related to the specific dental clinic
        $calendars = Calendar::where('id', $user->id)->paginate(10);

        return view('patient.calendar.calendar', compact('calendars'));
    }

    public function createCalendar($userId){

        $user = Auth::user();

        // Retrieve the user and ensure they belong to the same dental clinic
        $users = User::where('id', $userId)->where('id', $user->id)->firstOrFail();

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

        // Check for existing appointment
        $existingAppointment = Calendar::where([
            'appointmentdate' => $request->input('appointmentdate'),
            'appointmenttime'=> $request->input('appointmenttime')
        ])->first();

        if ($existingAppointment) {
            return redirect()->back()->withErrors(['appointmenttime' => 'This time is already booked. Could you please select a different time?']);
        }

        Calendar::create([
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
        ]);

        return redirect()->route('patient.appointment')->with('success', 'Appointment added successfully!');
    }

    public function deleteCalendar($id){

        $calendar = Calendar::findOrFail($id);
        

        if (Auth::user()->usertype !== 'admin' && Auth::id() !== $calendar->user_id) {
            return view('home');
        }
        
        $calendar->delete();
        
        return back()->with('success', 'Appointment deleted successfully!');
    }

    public function updateCalendar($id){
        
        $calendar = Calendar::findOrFail($id);

        if (Auth::user()->usertype !== 'admin' && Auth::id() !== $calendar->user_id) {
            return view('home');
        }

        return view('patient.calendar.updateCalendar')->with('calendar', $calendar);
    }

    public function updatedCalendar(Request $request, $id){

        $calendar = Calendar::findOrFail($id);

        if (Auth::user()->usertype !== 'admin' && Auth::id() !== $calendar->user_id) {
            return view('home');
        }

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'appointmentdate' => 'required|date',
            'appointmenttime' => 'required',
            'concern' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'age' => 'nullable|string',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|regex:/^0[0-9]{10}$/',
            'email' => 'nullable|string|lowercase|email|max:255',
            'medicalhistory' => 'nullable|string',
            'emergencycontactname' => 'nullable|string|max:255',
            'emergencycontactrelation' => 'nullable|string',
            'emergencycontactphone' => 'nullable|string|regex:/^0[0-9]{10}$/',
            'relationname' => 'nullable|string|max:255',
            'relation' => 'nullable|string',
        ]);
    
        $calendar->update([
            'user_id' => $request->input('user_id', $calendar->user_id),
            'appointmentdate' => $request->input('appointmentdate'),
            'appointmenttime' => $request->input('appointmenttime'),
            'concern' => $request->input('concern', $calendar->concern),
            'name' => $request->input('name', $calendar->name),
            'gender' => $request->input('gender', $calendar->gender),
            'birthday' => $request->input('birthday', $calendar->birthday),
            'age' => $request->input('age', $calendar->age),
            'address' => $request->input('address', $calendar->address),
            'phone' => $request->input('phone', $calendar->phone),
            'email' => $request->input('email', $calendar->email),
            'medicalhistory' => $request->input('medicalhistory', $calendar->medicalhistory),
            'emergencycontactname' => $request->input('emergencycontactname', $calendar->emergencycontactname),
            'emergencycontactrelation' => $request->input('emergencycontactrelation', $calendar->emergencycontactrelation),
            'emergencycontactphone' => $request->input('emergencycontactphone', $calendar->emergencycontactphone),
            'relationname' => $request->input('relationname', $calendar->relationname),
            'relation' => $request->input('relation', $calendar->relation),
        ]);

        return redirect()->route('patient.viewDetails', $calendar->id)->with('success', 'Appointment updated successfully!');
    }

    public function viewDetails($Id){
        
        $calendar = Calendar::where('id', $Id)->first();

        if (Auth::user()->usertype !== 'admin' && Auth::id() !== $calendar->user_id) {
            return view('home');
        }

        return view('patient.calendar.viewDetails', compact('calendar'));
    }
}
