<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cookie;

class Currency extends Model
{
    protected $fillable = [
        'name',
        'rate'
    ];

    public static function getRates()
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->get('https://api.exchangeratesapi.io/latest?base=USD');
        $list = json_decode($res->getBody()->getContents(), true);
        return $list;
    }

    public static function getCurrencyAmount($amount)
    {
        if(Cookie::get('Currency') === null) {
            Cookie::queue('Currency', 'USD', 28800);
            return $amount;
        }
        $currency = Cookie::get('Currency', 'USD');
        $currencyRate = Currency::where('name', $currency)->value('rate');
        return number_format($amount * ($currencyRate === 0 ? 1 : $currencyRate), 2);
    }

    public static function getCurrencyCode()
    {
        if(Cookie::get('Currency') === null) {
            Cookie::queue('Currency', 'USD', 28800);
            return 'USD';
        }
        $currency = Cookie::get('Currency', 'USD');
        return $currency;
    }
}
