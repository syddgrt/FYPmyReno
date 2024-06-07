<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaboration_id',
        'date',
        'time',
        'place',
    ];

    public function collaboration()
    {
        return $this->belongsTo(Collaborations::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
