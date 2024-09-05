<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Support\Facades\Log;
use App\Transaction;
use App\Order;

class PaypalController extends Controller
{
  /**
     * Create a new controller instance.
     *
     * @return void
     */
  public function __construct()
  { }

  /**
   * Retrieve IPN Response From PayPal
   *
   * @param \Illuminate\Http\Request $request
   */
  public function postNotify(Request $request)
  {
    Log::debug('New IPN request', [$request]);

    /** Setup express checkout */
    $provider = new ExpressCheckout;
    
    /** Prepare Paypal IPN valdiation to verify if the message is a valid PayPal message */
    $request->merge(['cmd' => '_notify-validate']);
    $post = $request->all();        
    
    /** Send validation request */
    Log::debug('Verfiy IPN', [$post]);
    $response = (string) $provider->verifyIPN($post);
    Log::debug('Verification', [$response]);
    /** If the validation is all well, we can handle the IPN call accordingly */
    if ($response === 'VERIFIED') {                      
      Log::debug('Verified IPN Response', [$response]);

      /** Handle case where the payment is now completed */
      if ($post['payment_status'] === 'Completed') {
        
        /** Make order paid */
        $order = Order::findByInvoiceNumber($post['invoice']);
        $order->order_paid = true;
        $order->save();

        /** Create new transaction for the IPN event */
        $transaction = new Transaction();
        $transaction->fill($post);
        $transaction->save();
      }
    }                            
  }      
}
