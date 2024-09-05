<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;


class OrderController extends Controller
{
    public function __construct()
    {
      /** Protect all functions of this controller for logged in guests */
      $this->middleware('auth');
    }
    
    public function index()
    {
      $user = auth()->user();
      $orders = Order::where('user_id', $user->id)->latest()->get();
      return view('shop.order.index', compact('orders'));
    }

    public function show(Request $request, $invoiceNumber) {
      $user = auth()->user();
      $order = Order::where('user_id', $user->id)->where('invoice_number', $invoiceNumber)->with('articles')->first();
      return view('shop.order.show', compact('order'));
    }
}
