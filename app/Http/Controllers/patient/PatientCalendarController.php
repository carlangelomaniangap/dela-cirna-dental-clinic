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
    public function getBookedTimes(Request $request)
{
    $date = $request->query('date');

    // Fetch appointments for the given date
    $bookedTimes = Calendar::whereDate('appointmentdate', $date)
        ->pluck('appointmenttime')
        ->toArray();

    return response()->json($bookedTimes);
}

    public function index(){

        // Get the dentalclinic_id from the authenticated user
        $dentalclinicId = Auth::user()->dentalclinic_id;

        // Retrieve calendars related to the specific dental clinic
        $calendars = Calendar::where('dentalclinic_id', $dentalclinicId)->paginate(10);

        return view('patient.calendar.calendar', compact('calendars'));
    }

    public function createCalendar($userId){

        // Get the dentalclinic_id from the authenticated user
        $dentalclinicId = Auth::user()->dentalclinic_id;

        // Retrieve the user and ensure they belong to the same dental clinic
        $users = User::where('id', $userId)->where('dentalclinic_id', $dentalclinicId)->firstOrFail();

        return view('patient.appointment.appointment', compact('users'));
    }
    
    public function storeCalendar(Request $request){

        $request->validate([
            'dentalclinic_id' => 'required', 'exists:dentalclinics,id',
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
            'dentalclinic_id' => $request->input('dentalclinic_id'),
            'appointmentdate' => $request->input('appointmentdate'),
            'appointmenttime'=> $request->input('appointmenttime')
        ])->first();

        if ($existingAppointment) {
            return redirect()->back()->withErrors(['appointmenttime' => 'This time is already booked. Could you please select a different time?']);
        }

        Calendar::create([
            'dentalclinic_id' => $request->dentalclinic_id,
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
        $calendar->delete();

        return back()->with('success', 'Appointment deleted successfully!');
    }

    public function updateCalendar($id){
        
        $calendar = Calendar::findOrFail($id);

        return view('patient.calendar.updateCalendar')->with('calendar', $calendar);
    }

    public function updatedCalendar(Request $request, $id){

        $calendar = Calendar::findOrFail($id);
        
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'appointmentdate' => 'required|date',
            'appointmenttime' => 'required|date_format:H:i',
            'concern' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'gender' => 'required|string',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^0[0-9]{10}$/',
            'email' => 'required|string|lowercase|max:255',
            'medicalhistory' => 'nullable|string',
            'emergencycontactname' => 'required|string|max:255',
            'emergencycontactrelation' => 'required|string',
            'emergencycontactphone' => 'required|string|regex:/^0[0-9]{10}$/',
            'name' => 'nullable|string|max:255',
            'relation' => 'nullable|string',
        ]);

        $calendar->update([
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

        return redirect()->route('patient.calendar')->with('success', 'Appointment updated successfully!');
    }
}
