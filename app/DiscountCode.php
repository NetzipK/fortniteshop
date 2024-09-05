<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public static function findActiveByCode($code)
    {
        return DiscountCode::where('active', true)->where('code', $code)->first();
    }

    public function getRevenue(DiscountCode $code)
    {
        return $code->percentage - $code->discount;
    }

    public function getDiscount($total)
    {
        return ($this->discount / 100) * floatval(str_replace(',', '.', $total));
    }
}
