<?php

namespace App\Observers;

use App\Models\Collaborations; 
use App\Models\Projects; 

class CollaborationObserver
{
    public function updated(Collaborations $collaboration)
    {
        // Check if collaboration status changed to "accepted"
        if ($collaboration->isDirty('status') && $collaboration->status === 'accepted') {
            // Update the corresponding project status to "In View"
            $project = $collaboration->project;
            $project->status = 'In View';
            $project->save();
        }
    }
}
