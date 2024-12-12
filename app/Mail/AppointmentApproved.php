<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class AppointmentApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $patientName;
    public $appointment;
    public $appointmentTime;
    public $appointmentDate;
    public $adminEmail;

    /**
     * Create a new message instance.
     *
     * @param  $patientName
     * @param  $appointment
     * @param  $dentalclinic
     * @param  $adminEmail
     * @return void
     */
    public function __construct($patientName, $appointment, $adminEmail)
    {
        $this->patientName = $patientName;
        $this->appointment = $appointment;
        $this->appointmentDate = Carbon::parse($appointment->appointmentdate)->format('F j, Y'); // Example format
        $this->appointmentTime = $appointment->appointmentTime;
        $this->adminEmail = $adminEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // The 'from' address is set to a general notification email
        // 'replyTo' is dynamically set based on the admin's email
        return $this->from('notification@bataandental.com', 'Bataan Dental')  // Sender
                    ->replyTo($this->adminEmail)  // Admin's email for replies
                    ->subject('Your Appointment has been Approved')  // Subject
                    ->view('admin.calendar.appointmentapproved')  // Email view
                    ->with([
                        'patientName' => $this->patientName,
                        'appointmentDate' => $this->appointmentDate,  // Date of the appointment
                        'appointmentTime' => $this->appointmentTime,  // Time of the appointment
                    ]);
    }
}