<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('shop.user.index');
    }

    public function wallet(Request $request)
    {
        $user = auth()->user();
        $amounts = $user->wallet->getFundsReduced();
        return view('shop.user.wallet', compact('amounts'));
    }


    public function orders(Request $request)
    {
        $user = auth()->user();
        $orders = \App\Order::where('user_id', $user->id)->limit(25)->latest()->get();
        return view('shop.user.orders', compact('orders'));
    }

    public function dcode(Request $request)
    {
        $request->user()->authorizeRoles('Contributor');

        $user = auth()->user();
        $dcode = $user->discountcode;
        return view('shop.user.dcode', compact('dcode'));
    }

    public function myItems(Request $request)
    {
        $request->user()->authorizeRoles('Contributor');
        $items = $request->user()->articles;
        return view('shop.user.myItems', compact('items'));
    }

    public function referrals(Request $request)
    {
        return view('shop.user.referrals');
    }

    public function ggPoints(Request $request)
    {
        return view('shop.user.ggpoints');
    }

    public function settings(Request $request)
    {
        return view('shop.user.settings');
    }
}
