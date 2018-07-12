<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cnp'
    ];

    /**
     * Get the user transactions.
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }
}
