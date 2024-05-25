<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'collaboration_id',
        'designer_id',
        'client_id',
        'rating',
        'feedback'
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class);
    }

    public function collaboration()
    {
        return $this->belongsTo(Collaboration::class);
    }

    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
