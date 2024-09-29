<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Models\User;
use App\Mail\AppointmentApproved;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminCalendarController extends Controller
{
    public function index(){

        $calendars = Calendar::all();

        return view('admin.calendar.calendar', compact('calendars'));
    }

    public function createCalendar($userId){

        $users = User::findOrFail($userId);

        return view('admin.appointment.appointment', compact('users'));
    }

    public function storeCalendar(Request $request){

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'appointmentdate' => 'required|date',
            'appointmenttime' => 'required|date_format:H:i',
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

        Calendar::create([
            'user_id' => $request->input('user_id'),
            'appointmentdate' => $request->input('appointmentdate'),
            'appointmenttime' => $request->input('appointmenttime'),
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

        return redirect()->route('appointment')->with('success', 'Appointment added successfully!');
    }
    
    public function approve($id) {
        // Find the appointment
        $calendar = Calendar::findOrFail($id);
    
        // Update the appointment status
        $calendar->approved = true;
        $calendar->save();
    
        $user = $calendar->user; // Assuming the Calendar model has a 'user' relationship
    
        if ($user) {
            $patientEmail = $user->email;
    
            // Log the patient email to ensure it's correct
            Log::info("Patient email: " . $patientEmail);
    
            try {
                // Log before sending email
                Log::info("Attempting to send email to: " . $patientEmail);
                
                // Send the approval email to the patient
                Mail::to($patientEmail)->send(new AppointmentApproved($calendar));
                
                // Log success
                Log::info("Email sent successfully to: " . $patientEmail);
            } catch (\Exception $e) {
                // Log error details
                Log::error("Failed to send email: " . $e->getMessage());
            }
        } else {
            Log::error("No user found for calendar ID: " . $id);
        }
    
        return redirect()->back()->with('success', 'Appointment approved! and Email sent!');
    }

    public function deleteCalendar($id){

        $calendar = Calendar::findOrFail($id);
        $calendar->delete();

        return back()->with('success', 'Appointment deleted successfully!');
    }

    public function updateCalendar($id){

        $calendar = Calendar::findOrFail($id);

        return view('admin.calendar.updateCalendar')->with('calendar', $calendar);
    }

    public function updatedCalendar(Request $request, $id){

        $calendar = Calendar::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'appointmentdate' => 'required|date',
            'appointmenttime' => 'required|date_format:H:i',
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

        $calendar->update([
            'user_id' => $request->input('user_id'),
            'appointmentdate' => $request->input('appointmentdate'),
            'appointmenttime' => $request->input('appointmenttime'),
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

        return redirect()->route('admin.calendar')->with('success', 'Appointment updated successfully!');
    }

    public function viewDetails($Id){
        
        $calendar = Calendar::where('id', $Id)->first();

        return view('admin.calendar.viewDetails', compact('calendar'));
    }
}
