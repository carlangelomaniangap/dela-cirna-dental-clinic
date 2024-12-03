<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientNotificationController extends Controller
{
    public function index(Request $request){
        
        // Get the selected filter from the request (defaults to 'all')
        $filter = $request->get('filter', 'all');

        // Fetch all notifications for the logged-in user (admin)
        $allNotifications = auth()->user()->notifications;

        // Fetch unread notifications (where read_at is null)
        $unreadNotifications = auth()->user()->unreadNotifications;

        // Fetch read notifications (where read_at is not null)
        $readNotifications = auth()->user()->readNotifications;

        // Initialize notifications variable based on filter
        if ($filter == 'unread') {
            $notifications = $unreadNotifications;
        } elseif ($filter == 'read') {
            $notifications = $readNotifications;
        } else {
            $notifications = $allNotifications;  // Default to all notifications
        }

        // Pass notifications to the view
        return view('patient.notifications.notifications', compact('notifications', 'filter'));
    }

    public function markAsRead($notificationId){
        $notification = auth()->user()->notifications->find($notificationId);
        $notification->markAsRead(); // Mark as read when clicked

        // Redirect to the appointment details page
        return redirect()->route('patient.viewDetails', $notification->data['appointment_id']);
    }
}