<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Carbon\Carbon;

class DiscordController extends Controller
{
    protected $guarded = [];
    public function deliverOrder(Request $request)
    {
        $invoiceId = $request->get('invoiceId');
        $deliveredBy = $request->get('by');
        $order = Order::findByInvoiceNumber($invoiceId);
        if(!is_null($order)) {
            $order->order_delievered = true;
            $order->order_delievered_by = $deliveredBy;
            $order->order_delievered_at = Carbon::now();
            $order->save();
            return "200";
        } else {
            return "400";
        }
    }

    public function refundOrder(Request $request)
    {
        $invoiceId = $request->get('invoiceId');
        $deliveredBy = $request->get('by');
        $order = Order::findByInvoiceNumber($invoiceId);
        if(!is_null($order)) {
            $order->order_refunded = true;
            $order->order_delievered = false;
            $order->save();
            return "200";
        } else {
            return "400";
        }
    }

    public function restoreOrder(Request $request)
    {
        $invoiceId = $request->get('invoiceId');
        $order = Order::findByInvoiceNumber($invoiceId);
        if(!is_null($order)) {
            $order->order_delievered = false;
            $order->order_delievered_by = '';
            $order->save();
            app('App\Http\Controllers\CheckoutController')->notifyDiscord($order);
            return "200";
        } else {
            return "400";
        }
    }
}
