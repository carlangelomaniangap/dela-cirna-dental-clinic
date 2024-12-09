<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use App\Mail\AppointmentApproved;
use App\Models\User;
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

    public function approve($appointmentId, $status) {
        // Find the appointment
        $calendar = Calendar::findOrFail($appointmentId);

        // Ensure that the date and time are Carbon instances
        $appointmentDate = Carbon::parse($calendar->appointmentdate)->format('F j, Y');  // e.g., 'December 3, 2024'
        $appointmentTime = Carbon::parse($calendar->appointmenttime)->format('h:i A');  // e.g., '02:30 PM'

        // Check the status and update accordingly
        if ($status == 'approve') {
            $calendar->approved = 'Approved'; // Set to Approved
            $this->sendApprovalEmail($calendar);  // Send approval email
            $message = "Your appointment for {$appointmentDate} at {$appointmentTime} has been approved and an email has been sent!";
        } elseif ($status == 'complete') {
            $calendar->approved = 'Completed'; // Set to Completed
            $message = "Your appointment for {$appointmentDate} at {$appointmentTime} has been completed!";
        } elseif ($status == 'approvecancel') {
            $calendar->approved = 'ApprovedCancelled'; // Set to Cancelled
            $message = "Your appointment for {$appointmentDate} at {$appointmentTime} has been cancelled!";
        } elseif ($status == 'pendingcancel') {
            $calendar->approved = 'PendingCancelled'; // Keep the status as 'Pending'
            $message = "Your appointment for {$appointmentDate} at {$appointmentTime} has been cancelled!";
        }

        // Save the status update
        $calendar->save();

        // Send notification to the patient
        $patient = $calendar->user;  // Assuming you have a 'patient' relationship on the Calendar model
        $patient->notify(new StatusAppointmentNotifications($calendar, $message));

        return redirect()->back()->with('success', $message);
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
