<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Collaborations; // Import the Schedules model
use App\Models\Schedules; // Import the Schedules model

class Projects extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id','budget', 'status'];

    // Define the relationship with the user who created the project

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function designer()
    {
        return $this->belongsTo(User::class, 'designer_id');
    }
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
        return $this->hasMany(Collaborations::class, 'project_id');
    }

    public function financialData()
    {
        return $this->hasOne(FinancialData::class, 'project_id');
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }

    // public function schedules()
    // {
    //     return $this->hasMany(Schedules::class, 'project_id');
    // }
}
