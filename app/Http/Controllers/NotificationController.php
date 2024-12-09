<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function __construct(){

        // Ensure that the user is authenticated before performing any actions
        $this->middleware('auth');
    }

    public function markAsRead($notificationId){
        
        // Get the currently authenticated user (could be admin or patient)
        $user = auth()->user();

        // Retrieve the specific notification by its ID
        $notification = $user->notifications->find($notificationId);

        // Mark the notification as read
        $notification->markAsRead();

        // Redirect based on the type of notification, separate by user type (usertype)
        if (isset($notification->data['appointment_id'])) {
            // Check if the user is an admin or patient using the 'usertype' attribute
            if ($user->usertype == 'admin') {
                return redirect()->route('admin.viewDetails', $notification->data['appointment_id']);
            } else if ($user->usertype == 'patient') {
                return redirect()->route('patient.viewDetails', $notification->data['appointment_id']);
            }
        } elseif (isset($notification->data['message'])) {
            // Check if the user is an admin or patient using the 'usertype' attribute
            if ($user->usertype == 'admin') {
                return redirect()->route('admin.messages', $notification->data['sender_id']);
            } else if ($user->usertype == 'patient') {
                return redirect()->route('patient.messages', $notification->data['sender_id']);
            }
        }

        return redirect()->back();
    }
}