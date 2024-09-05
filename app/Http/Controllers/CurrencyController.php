<?php

namespace App\Http\Controllers;

use App\Currency;
use Cookie;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        // $currency = Currency::getRates();
        // foreach($currency['rates'] as $c => $c_val) {
        //     Currency::updateOrCreate(
        //         ['name' => $c],
        //         ['rate' => $c_val]
        //     );
        // }
        // dd($currency['rates']);

    }

    public function setCurrency(Request $request, $currency)
    {
        Cookie::queue('Currency', $currency, 28800);
        return redirect()->back();
    }
}
