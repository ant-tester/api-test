<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'amount'
    ];

    protected $appends = [
        'date',
        'formatted_amount'
    ];

    /**
     * Get the transaction customer.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    /**
     * Return formatted created_at
     * @return string
     */
    public function getDateAttribute()
    {
        return $this->created_at->format('d.m.Y');
    }

    /**
     * Return formatted amount
     * @return string
     */
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2, '.', '');
    }
}
