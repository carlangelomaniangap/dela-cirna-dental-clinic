<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Notifications\NewMessageNotification;
use App\Models\Message;
use App\Models\User;

class AdminMessagesController extends Controller
{
    
    public function index(){

    $users = User::where('id', '!=', auth()->id())->get();

    // Get users with their last messages and timestamps
    $usersWithLastMessage = $users->map(function ($user) {
        $lastMessage = Message::where(function ($query) use ($user) {
            $query->where('sender_id', auth()->id())
                ->where('recipient_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->where('recipient_id', auth()->id());
        })->latest()->first();

        $user->last_message = $lastMessage
            ? ($lastMessage->sender_id == auth()->id() ? 'You: ' : $user->name . ': ') . $lastMessage->message
            : 'No messages yet';
        $user->last_message_time = $lastMessage ? $lastMessage->created_at : null;

        return $user;
    });

    // Sort users by the last message timestamp in descending order
    $usersWithLastMessage = $usersWithLastMessage->sortByDesc('last_message_time');

    $messages = Message::all();

    return view('admin.messages.messages', compact('users', 'messages', 'usersWithLastMessage'));
    }

    public function storeMessage(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id', // Ensure recipient exists in users table
            'message' => 'required|string',
        ]);

        // Create the message
        $message = Message::create([
            'sender_id' => auth()->id(), // Assuming sender is the authenticated user
            'recipient_id' => $request->input('recipient_id'),
            'message' => $request->input('message'),
        ]);

        // Send notification to the recipient
        $recipient = User::find($request->input('recipient_id'));
        $sender = auth()->user();

        // Check if there's an unread notification from this sender
        $existingNotification = $recipient->unreadNotifications()
            ->where('type', NewMessageNotification::class)
            ->where('data->sender_id', $sender->id)
            ->first();

        if (!$existingNotification) {
            // If no unread notification exists, create a new one
            $recipient->notify(new NewMessageNotification($message, $sender));
        }

        return redirect()->route('admin.messages')->with('success', 'Message sent successfully!');
    }

    public function search(Request $request){

        $query = $request->input('query');

        // Retrieve users whose names match the search query
        $users = User::where('name', 'like', "%$query%")
                    ->where('id', '!=', auth()->id()) // Exclude current authenticated user
                    ->get();

        // Get all messages associated with the retrieved users
        $userIds = $users->pluck('id')->toArray();
        $messages = Message::whereIn('sender_id', $userIds)->orWhereIn('recipient_id', $userIds)->get();

        return view('admin.messages.messages', compact('users', 'messages'));
    }

    public function markNotificationAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notification marked as read.');
    }
}