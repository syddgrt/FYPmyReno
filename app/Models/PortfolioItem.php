<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    protected $fillable = ['portfolio_id', 'type', 'content'];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
