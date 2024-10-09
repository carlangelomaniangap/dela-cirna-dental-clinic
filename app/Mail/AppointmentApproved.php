<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class AppointmentApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $appointmentTime;
    public $appointmentDate;
    public $dentalclinic;
    
    public function __construct($appointment, $dentalclinic){

        $this->appointment = $appointment;

        $this->appointmentDate = Carbon::parse($appointment->appointmentdate)->format('F j, Y'); // Example format
        $this->appointmentTime = Carbon::parse($appointment->appointmenttime)->format('g:i A'); // Example format
        $this->dentalclinic = $dentalclinic;
    }

    public function build(){

        return $this->subject('Your Appointment has been Approved')
                    ->view('admin.calendar.appointmentapproved')
                    ->with([
                        'appointmentDate' => $this->appointmentDate,
                        'appointmentTime' => $this->appointmentTime,
                        'dentalclinicname' => $this->dentalclinic->dentalclinicname,
                    ]);
    }
}

