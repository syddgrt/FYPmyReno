<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialData extends Model
{
    protected $fillable = ['client_id', 'designer_id', 'type', 'amount', 'description', 'date'];

    protected $table = 'financial_datas';
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Similarly for a Designer model
    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }
}

