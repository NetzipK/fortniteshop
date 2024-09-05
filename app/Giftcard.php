<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Auth;

class Giftcard extends Model
{
    protected $fillable = [
        'used',
        'code',
        'amount',
        'user_id',
        'expires_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function createGiftcard($amount)
    {
        $voucher = Giftcard::create([
            'used' => false,
            'code' => $this->getUniqueGiftcard(),
            'amount' => $amount,
            'user_id' => Auth::user()->id,
            'expires_at' => Carbon::now()->addMonths(6),
        ]);
        return $voucher;
    }

    public function generate()
    {
        $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ1234567890';
        $mask = '****-****-****-****';
        $length = substr_count($mask, '*');
        $characters = collect(str_split($characters));
        $prefix = 'FSGG-';
        $code = $prefix;
        for ($i = 0; $i < $length; $i++) {
            $mask = str_replace_first('*', $characters->random(1)->first(), $mask);
        }

        $code .= $mask;

        return $code;
    }

    public function getUniqueGiftcard()
    {
        $giftcard = $this->generate();

        while(Giftcard::where('code', $giftcard)->count() > 0) {
            $giftcard = $this->generate();
        }

        return $giftcard;
    }
}
