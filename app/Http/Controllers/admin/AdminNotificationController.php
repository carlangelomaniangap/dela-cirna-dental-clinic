<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function index(Request $request)
    {
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

        // Pass notifications and the current filter to the view
        return view('admin.notifications.notifications', compact('notifications', 'filter'));
    }

    public function markAsRead($notificationId)
    {
        // Retrieve the specific notification
        $notification = auth()->user()->notifications->find($notificationId);

        // Check if the notification exists
        if (!$notification) {
            return redirect()->back()->with('error', 'Notification not found.');
        }

        // Mark the notification as read
        $notification->markAsRead();

        // Redirect based on the type of notification
        if (isset($notification->data['appointment_id'])) {
            // Redirect to the appointment details page
            return redirect()->route('admin.viewDetails', $notification->data['appointment_id']);
        } elseif (isset($notification->data['message'])) {
            // Redirect to the messages page, focusing on the sender's conversation
            return redirect()->route('admin.messages', $notification->data['sender_id']);
        }

        // Default redirect if no specific type is identified
        return redirect()->back()->with('info', 'Notification marked as read.');
    }
}