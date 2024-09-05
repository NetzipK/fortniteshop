<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Coupon extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    static public function findActiveByCode($code) {
        return Coupon::where('active', true)->where('code', $code)->first();
    }

    public function discount($total)
    {
        if ($this->is_fixed) {
            return $this->value;
        } elseif ($this->is_percent) {
            return ($this->percent_off / 100) * floatval(str_replace(',', '.', $total));
        } else {
            return 0;
        }
    }
}
