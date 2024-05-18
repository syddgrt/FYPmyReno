<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Projects;

class Collaborations extends Model
{
    use HasFactory;

    protected $fillable = [
        'designer_id',
        'client_id',
        'project_id',
        'status',
    ];

    /**
     * Get the designer associated with the collaboration.
     */
    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    /**
     * Get the client associated with the collaboration.
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * Get the project associated with the collaboration.
     */
    public function project()
    {
        return $this->belongsTo(Projects::class);
    }

    public function appointment()
    {
        return $this->hasOne(Schedules::class, 'collaboration_id');
    }
}
