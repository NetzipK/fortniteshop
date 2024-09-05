<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $table = 'wallet_transactions';

    protected $fillable = [
        'wallet_id',
        'amount',
        'invoice_number',
        'type',
        'meta',
    ];

    protected $casts = [
        'amount' => 'float',
        'meta' => 'array'
    ];

    public function wallet()
    {
        return $this->belongsTo('App\Wallet');
    }

    public function getAmountWithSignAttribute()
    {
        return in_array($this->type, ['deposit', 'credit', 'earning'])
            ? '+' . $this->amount
            : '-' . $this->amount;
    }

}
