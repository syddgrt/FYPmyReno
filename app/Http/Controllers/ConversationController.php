<?php

// app/Http/Controllers/ConversationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Chatify\Models\ChMessage as Message;
use Chatify\Models\ChConversation as Conversation;

class ConversationController extends Controller
{
    public function startConversation(Request $request, User $designer)
    {
        // Find or create a conversation between the authenticated user and the designer
        $conversation = Conversation::where('user1', $request->user()->id)
                        ->where('user2', $designer->id)
                        ->orWhere(function($query) use ($request, $designer) {
                            $query->where('user1', $designer->id)
                                  ->where('user2', $request->user()->id);
                        })->first();

        if (!$conversation) {
            $conversation = new Conversation();
            $conversation->user1 = $request->user()->id;
            $conversation->user2 = $designer->id;
            $conversation->save();
        }

        // Redirect to the chat view with the designer's ID
        return redirect()->route('chat', ['id' => $designer->id]);
    }
}
