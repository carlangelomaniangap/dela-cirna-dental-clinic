<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentNotifications extends Notification
{
    use Queueable;

    protected $calendar;
    protected $message;

    // Pass the appointment object to the notification
    public function __construct($calendar, $message){
        
        $this->calendar = $calendar;
        $this->message = $message; // Store the message
    }

    // Specify the notification channels (we'll use 'database' here)
    public function via($notifiable){

        return ['database'];  // You can also add other channels (like mail) if needed
    }

    // Define the data to store in the database notifications table
    public function toDatabase($notifiable){

        return [
            'message' => $this->message,
            'appointment_id' => $this->calendar->id,
            'appointment_date' => $this->calendar->appointmentdate,
            'appointment_time' => $this->calendar->appointmenttime,
            'url' => route('admin.viewDetails', $this->calendar->id), // URL to view appointment details in admin
        ];
    }
}