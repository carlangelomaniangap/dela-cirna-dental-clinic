<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Mail\AppointmentApproved;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\StatusAppointmentNotifications;
use Carbon\Carbon;

class AdminCalendarController extends Controller
{
    public function index(){

        $calendars = Calendar::all();

        return view('admin.calendar.calendar', compact('calendars'));
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
            'appointmenttime' => 'required|in:8:00 AM - 9:00 AM,9:00 AM - 10:00 AM,10:00 AM - 11:00 AM,11:00 AM - 12:00 PM,3:00 PM - 4:00 PM,4:00 PM - 5:00 PM,5:00 PM - 6:00 PM,6:00 PM - 7:00 PM,7:00 PM - 8:00 PM',
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

    public function completeAppointment(Request $request, $calendarId){
        // Validate the reason for completion
        $request->validate([
            'complete_reason' => 'required|string|max:255',
        ]);
    
        // Find the calendar entry by ID
        $calendar = Calendar::findOrFail($calendarId);
    
        // Update the status to 'Completed' and save the completion reason
        $calendar->status = 'Completed';
        $calendar->completion_reason = $request->input('complete_reason'); // Ensure the field 'completion_reason' exists in your database
        $calendar->save();
    
        // Prepare the message for the notification
        $appointmentDate = Carbon::parse($calendar->appointmentdate)->format('F j, Y');  // e.g., 'December 3, 2024'
        $appointmentTime = $calendar->appointmenttime;
        $PatientName = $calendar->user->name;
        $message = "Your appointment for {$appointmentDate} at {$appointmentTime} has been completed! Procedure Status: {$calendar->completion_reason}";
        
        // Send the notification to the patient
        $patient = $calendar->user; // Assuming you have a 'user' relationship on the Calendar model
        $patient->notify(new StatusAppointmentNotifications($calendar, $message, null, $calendar->completion_reason));
    
        // Redirect back or to the previous page with a success message
        return redirect()->route('admin.viewDetails', $calendarId)->with('success', 'Appointment marked as completed successfully!');
    }
    
    public function viewDetails($Id){
        
        $calendar = Calendar::where('id', $Id)->first();

        return view('admin.calendar.viewDetails', compact('calendar'));
    }

    public function approve($appointmentId, $status, Request $request) {
        // Find the appointment
        $calendar = Calendar::findOrFail($appointmentId);

        // Ensure that the date and time are Carbon instances
        $appointmentDate = Carbon::parse($calendar->appointmentdate)->format('F j, Y');  // e.g., 'December 3, 2024'
        $appointmentTime = $calendar->appointmenttime;

        $PatientName = $calendar->user->name;

        $cancelReason = $request->input('cancel_reason', 'No reason provided'); // Default to 'No reason provided' if empty
        
        // Check the status and update accordingly
        if ($status == 'approve') {
            $calendar->status = 'Approved'; // Set to Approved
            $this->sendApprovalEmail($calendar);  // Send approval email
            $message = "Your appointment for {$appointmentDate} at {$appointmentTime} has been approved and an email has been sent!";
            $AdminMessage = "{$PatientName} appointment for {$appointmentDate} at {$appointmentTime} has been approved and an email has been sent!";
        } elseif ($status == 'approvecancel') {
            $calendar->status = 'ApprovedCancelled'; // Set to Cancelled
            $message = "Your appointment for {$appointmentDate} at {$appointmentTime} has been cancelled! Reason: {$cancelReason}";
            $AdminMessage = "{$PatientName} appointment for {$appointmentDate} at {$appointmentTime} has been cancelled! Reason: {$cancelReason}";
        } elseif ($status == 'pendingcancel') {
            $calendar->status = 'PendingCancelled'; // Keep the status as 'Pending'
            $message = "Your appointment for {$appointmentDate} at {$appointmentTime} has been cancelled! Reason: {$cancelReason}";
            $AdminMessage = "{$PatientName} appointment for {$appointmentDate} at {$appointmentTime} has been cancelled! Reason: {$cancelReason}";
        }

        // Save the status update
        $calendar->save();

        // Send notification to the patient
        $patient = $calendar->user; // Assuming you have a 'patient' relationship on the Calendar model
        $patient->notify(new StatusAppointmentNotifications($calendar, $message));

        return redirect()->back()->with('success', $AdminMessage);
    }

    private function sendApprovalEmail($calendar){

        // Assuming the Calendar model has a 'user' relationship
        $user = $calendar->user;
        if ($user) {
            $adminEmail = Auth::user()->email;
            $patientEmail = $user->email;
            $patientName = $user->name;

            try {
                // Send the approval email to the patient
                Mail::mailer('notification')->to($patientEmail)->queue(new AppointmentApproved($patientName, $calendar, $adminEmail));
            } catch (\Exception $e) {
                // Handle any email sending failures
                return redirect()->back()->with('error', 'Failed to send email: ' . $e->getMessage());
            }
        }
    }
}
