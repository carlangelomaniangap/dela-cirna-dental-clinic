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
        $messages = Message::all();

        return view('patient.messages.messages', compact('users', 'messages'));
    }

    public function storeMessage(Request $request){

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

        return redirect()->route('patient.messages')->with('success', 'Message sent successfully!');
    }
    
}