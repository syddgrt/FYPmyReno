<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $table = 'messages'; // Specify the table name explicitly

    protected $fillable = [
        'subject',
    ];

    /**
     * Define the relationship with users participating in the conversation.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Define the relationship with messages in the conversation.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
