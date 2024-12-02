<?php

namespace App\Http\Controllers\patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Message;
use App\Models\User;

class PatientMessagesController extends Controller
{
    
    public function index(){

        $users = User::where('id', '!=', auth()->id())->get();
        
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

        $usersWithLastMessage = $usersWithLastMessage->sortByDesc('last_message_time');

        $messages = Message::all();

        return view('patient.messages.messages', compact('users', 'messages', 'usersWithLastMessage'));
    }

    public function storeMessage(Request $request){

        $request->validate([
            'recipient_id' => 'required|exists:users,id', // Ensure recipient exists in users table
            'message' => 'required|string',
        ]);

        // Create the message
        Message::create([
            'sender_id' => auth()->id(), // Assuming sender is the authenticated user
            'recipient_id' => $request->input('recipient_id'),
            'message' => $request->input('message'),
        ]);

        return redirect()->route('patient.messages')->with('success', 'Message sent successfully!');
    }
    
}