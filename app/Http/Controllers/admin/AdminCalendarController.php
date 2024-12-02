<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Mail\AppointmentApproved;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCalendarController extends Controller
{
    public function index(){

        $calendars = Calendar::all();

        return view('admin.calendar.calendar', compact('calendars'));
    }
    
    public function approve($id) {
        // Find the appointment
        $calendar = Calendar::findOrFail($id);
    
        // Update the appointment status
        $calendar->approved = 'Approved';
        $calendar->save();
    
        $user = $calendar->user; // Assuming the Calendar model has a 'user' relationship
    
        if ($user) {
            $adminEmail = Auth::user()->email;
            $patientEmail = $user->email;
            $patientName = $user->name;
            
            try {
                // Get the dental clinic associated with the appointment
                $dentalClinic = $calendar->dentalClinic; // Assuming a relationship exists

                // Send the approval email to the patient
                Mail::mailer('notification')->to($patientEmail)->queue(new AppointmentApproved($patientName, $calendar, $dentalClinic, $adminEmail));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
            }
        }
    
        return redirect()->back()->with('success', 'Appointment approved! and Email sent!');
    }

    public function updateCalendar($id){

        $calendar = Calendar::findOrFail($id);

        return view('admin.calendar.updateCalendar')->with('calendar', $calendar);
    }

    public function updatedCalendar(Request $request, $id){

        $calendar = Calendar::findOrFail($id);

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

        return redirect()->route('admin.viewDetails', $calendar->id)->with('success', 'Appointment updated successfully!');
    }

    public function viewDetails($Id){
        
        $calendar = Calendar::where('id', $Id)->first();

        return view('admin.calendar.viewDetails', compact('calendar'));
    }
}
