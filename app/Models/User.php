<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Cmgmyr\Messenger\Traits\Messagable;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
// use Cmgmyr\Messenger\Models\Conversation; // Update the namespace

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Messagable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Add the 'role' attribute here
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Define the one-to-one relationship with Portfolio
    public function portfolio()
    {
        return $this->hasOne(Portfolio::class);
    }

    public function projects()
    {
        return $this->hasMany(Projects::class);
        
    }

    // Check if the user is a designer
    public function isDesigner()
    {
        return $this->role === 'Designer';
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user_id'); // Fix the namespace here
    }

    public function messages()
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }

    // public function portfolio()
    // {
    //     return $this->hasOne(Portfolio::class, 'user_id');
    // }


    public function findConversation($recipientId)
    {
        // Find the conversation between the current user and the recipient
        return Conversation::where('user_id', Auth::id())
            ->where('recipient_id', $recipientId)
            ->first();
    }

    public function startConversation($recipient)
    {
        // Create a new conversation
        return Conversation::create([
            'user_id' => Auth::id(),
            'recipient_id' => $recipient->id,
        ]);
    }

    public function getConversationWith($recipient)
    {
        // Get the conversation between the current user and the recipient
        return Conversation::where(function ($query) use ($recipient) {
            $query->where('user_id', Auth::id())
                  ->where('recipient_id', $recipient->id);
        })->orWhere(function ($query) use ($recipient) {
            $query->where('recipient_id', Auth::id())
                  ->where('user_id', $recipient->id);
        })->first();
    }

    public function initiatedCollaborations()
    {
        return $this->hasMany(Collaboration::class, 'designer_id');
    }

    /**
     * Get the collaborations initiated by the user's projects (as a client).
     */
    public function collaborations()
    {
        return $this->hasManyThrough(Collaboration::class, Project::class, 'client_id', 'project_id');
    }
    
}
