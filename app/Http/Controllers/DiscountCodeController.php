<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DiscountCode;
use Gloudemans\Shoppingcart\Facades\Cart;

class DiscountCodeController extends Controller
{
    public function addDCToCart(Request $request)
    {
        $coupon = DiscountCode::findActiveByCode($request->code);

        if(is_null($coupon)) {
            return redirect()->back()->with('coupon-error', true);
        }
        session()->put('coupon', [
          'name' => $coupon->code,
          'discount' => $coupon->getDiscount(Cart::total()),
        ]);
        return redirect()->back()->with('coupon-applied', true);
    }

    public function removeDCFromCart()
    {
      session()->forget('coupon');
      return redirect()->back()->with('coupon-removed', true);
    }

    public function changeCode(Request $request)
    {
        request()->validate([
            'code' => 'required|min:4|max:10',
        ]);
        $code = $request->get('code');
        $coupon = DiscountCode::where('user_id', $request->user()->id)->where('active', true)->first();
        if($coupon->exists()) {
            $coupon->code = $code;
            $coupon->save();
            return redirect()->back()->with('dc-success', true);
        } else {
            return redirect()->back()->with('dc-error', true);
        }
    }
}
