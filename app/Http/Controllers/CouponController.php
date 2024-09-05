<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Coupon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Jobs\UpdateCoupon;

class CouponController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addCouponToCart(Request $request)
    {
      /** Verify if code exists */
      $coupon = Coupon::findActiveByCode($request->code);

      if (!empty($coupon) && $coupon->is_user_specific) {
        if (Auth::guest()) {
          return redirect()->back()->with('coupon-error', true);
        }
      }

      session()->put('coupon', [
        'name' => $coupon->code,
        'discount' => $coupon->getDiscount(Cart::total()),
      ]);

      return redirect()->back()->with('coupon-applied', true);
    }

    public function removeCouponFromCart()
    {
      session()->forget('coupon');
      return redirect()->back()->with('coupon-removed', true);
    }

}
