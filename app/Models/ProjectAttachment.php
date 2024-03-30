<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['file_path', 'type'];

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id'); // Specify the foreign key
    }
}

