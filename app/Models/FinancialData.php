<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialData extends Model
{
    protected $fillable = ['project_id', 'cost_estimation', 'actual_cost', 'tax', 'additional_fees'];

    protected $table = 'financial_datas';
    
    // Assuming each financial data entry is associated with a project
    public function project()
    {
        return $this->belongsTo(Projects::class);
    }

    // You might not need direct client and designer relationships if they can be inferred through the project
}
