<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MessageController extends Controller
{
    // MessageController.php
    // MessageController.php
    public function showConversations($recipientId = null)
    {
        $user = Auth::user();
        
        if ($recipientId) {
            $conversation = $user->findConversation($recipientId);

            if (!$conversation) {
                $recipient = User::findOrFail($recipientId);
                $conversation = $user->startConversation($recipient);
            }

            return view('conversations.index', compact('conversation'));
        }
        
        // If no recipientId provided, return a view indicating that no conversations are available
        return view('conversations.no-conversations');
    }



    public function sendMessage(Request $request, $recipientId)
    {
        $user = Auth::user();
        $recipient = User::findOrFail($recipientId);
        $user->message($recipient, $request->message);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    public function startConversation(Request $request, $recipientId)
    {
        $user = Auth::user();
        $recipient = User::findOrFail($recipientId);

        // Check if a conversation already exists between the users
        $conversation = $user->getConversationWith($recipient);

        // If a conversation does not exist, start a new one
        if (!$conversation) {
            $conversation = $user->startConversation($recipient);
        }

        // Send the initial message
        $user->message($recipient, $request->message);

        return redirect()->route('conversations.index')->with('success', 'Conversation started successfully!');
    }
}
