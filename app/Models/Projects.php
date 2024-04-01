<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id'];

    // Define the relationship with the user who created the project
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship with project attachments
    public function attachments()
    {
        return $this->hasMany(ProjectAttachment::class, 'project_id');
    }

    public function collaborations()
    {
        return $this->hasMany(Collaborations::class);
    }

    public function canBeEditedByUser($user)
    {
        if ($this->user_id === $user->id) {
            return true;
        }

        return $this->collaborations()->where('status', 'accepted')->where('designer_id', $user->id)->exists();
    }
}
