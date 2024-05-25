<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Messagable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
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
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
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
        return $this->role === 'designer';
    }

    // Check if the user is a client
    public function isClient()
    {
        return $this->role === 'client';
    }

    // Check if the user is an admin
    public function isAdmin()
    {
        return $this->role === 'ADMIN';
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }

    public function collaborations()
    {
        return $this->hasMany(Collaborations::class);
    }

    public function financialData()
    {
        return $this->hasOne(FinancialData::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'project_id');
    }

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

    public function reviewsReceived()
    {
        return $this->hasMany(Reviews::class, 'designer_id');
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Reviews::class, 'client_id');
    }

}
