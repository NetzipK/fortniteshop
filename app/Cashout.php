<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashout extends Model
{
    protected $fillable = ['amount', 'paypal', 'currency'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function findByUser($user)
    {
        $userID = \App\User::where('name', $user)->pluck('id');
        // dd(Cashout::where('user_id', $userID)->where('accepted', null)->first());
        return Cashout::where('user_id', $userID)->where('accepted', null)->first();
    }
}
