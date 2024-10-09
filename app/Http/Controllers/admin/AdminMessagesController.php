<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminMessagesController extends Controller
{
    
    public function index(){
        
        // Get the dentalclinic_id from the authenticated user
        $dentalclinicId = Auth::user()->dentalclinic_id;

        // Retrieve users (patients) from the same dental clinic, excluding the logged-in user
        $users = User::where('dentalclinic_id', $dentalclinicId)->where('id', '!=', auth()->id())->where('usertype', 'patient')->get();
        
        $messages = Message::all();

        return view('admin.messages.messages', compact('users', 'messages'));
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

        return redirect()->route('admin.messages')>with('success', 'Message sent successfully!');
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
}