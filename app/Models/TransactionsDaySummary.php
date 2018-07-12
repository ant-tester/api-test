<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionsDaySummary extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'summary', 'date'
    ];
}
