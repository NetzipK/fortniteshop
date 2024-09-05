<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\ExpressCheckout;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use App\Order;
use Illuminate\Support\Facades\Hash;
use NotificationChannels\Discord\Discord;
use App\DiscountCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Sichikawa\LaravelSendgridDriver\Transport\SendgridTransport;
use Sichikawa\LaravelSendgridDriver\SendGrid;

use App\Paysafecard;
use App\Wallet;
use App\User;
use Mollie\Laravel\Facades\Mollie;

/* NOTIFICATIONS */
use App\Notifications\OrderPaid;

// TODO REWORK!
class CheckoutController extends Controller
{
  /**
     * Create a new controller instance.
     *
     * @return void
     */
  public function __construct()
  { }

  /** Send the user to the paypal invoice page */
  public function paypalPaymentShowInvoicePage(Request $request, $invoiceId, $pinCode) {
    $order = Order::where('invoice_number', $invoiceId)->where('order_password', $pinCode)->where('order_failed', false)->first();
    return view('shop.checkout.paypal-success', compact('order'));
  }

   /** Send the user to the paypal failed page */
   public function paypalPaymentError(Request $request) {
    Order::setFailedOrderByPaypalToken($request->token);
    return view('shop.checkout.paypal-error');
  }

  public function paysafecardPaymentShowInvoicePage(Request $request, $invoiceId, $pinCode) {
    $order = Order::where('invoice_number', $invoiceId)->where('order_password', $pinCode)->where('order_failed', false)->first();
    return view('shop.checkout.paysafecard-success', compact('order'));
  }

   /** Send the user to the paypal failed page */
   public function paysafecardPaymentError(Request $request) {
    return view('shop.checkout.paysafecard-error');
  }

  public function molliePaymentShowInvoicePage(Request $request, $invoiceId, $pinCode) {
    $order = Order::where('invoice_number', $invoiceId)->where('order_password', $pinCode)->first();
    return view('shop.checkout.paysafecard-success', compact('order'));
  }

  public function walletPaymentShowInvoicePage(Request $request, $invoiceId, $pinCode)
  {
      $order = Order::where('invoice_number', $invoiceId)->where('order_password', $pinCode)->first();
      return view('shop.checkout.paysafecard-success', compact('order'));
  }

  public function preparePaypalProvider() {
    /** Use express checkout for this payment */
    $provider = new ExpressCheckout;
    /** Set some options */
    $options = [
      'BRANDNAME' => 'FortniteMall.gg',
      'LOGOIMG' => asset('/assets/images/fortnite/lama-min.png'),
    ];
    $provider->addOptions($options);

    /** Set currency for the payment */
    $provider->setCurrency('USD');
    return $provider;
  }

  /** Create order */
  public function createPaypalOrder(Request $request)
  {
    Log::info('Creating new paypal order');

    request()->validate([
        'email' => 'required|email',
        'platform' => 'required|in:PC,PS4,XBOX',
        'epic_id' => 'required|min:3|max:20',
        'discord_id' => 'nullable|regex:/\w+#\d{4}/m',
    ]);

    $provider = $this->preparePaypalProvider();

    /** Prepare order */
    $random_pin = rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    $invoice_number = Str::uuid();
    $invoice_description = $invoice_number;
    Log::info('Prepare order', [$invoice_number]);

    /** Prepare paypal data - KEEP IN SYNC WITH BELOW FUNCTION*/
    $data['items'] = [];
    $data['invoice_id'] = $invoice_number;
    $data['invoice_description'] = $invoice_description;
    $data['custom'] = 'test';
    $data['return_url'] = route('checkout.paypal.success', ['invoice_id' => $invoice_number, 'order_pin' => $random_pin]);
    $data['cancel_url'] = route('checkout.paypal.error');

    /** Loop all Cart items to create the payment. Use data from model to prevent user modified data*/
    $cart = Cart::content();
    foreach($cart as $cartItem) {
      $item = [
        'name' => $cartItem->model->name,
        'price' => $cartItem->model->price,
        'qty' => $cartItem->qty,
      ];
      array_push($data['items'], $item);
    }

    /** Calclate subtotal before discounts */
    $subtotal = 0;
    $discount = 0;
    foreach ($data['items'] as $item) {
      $subtotal += $item['price'] * $item['qty'];
    }

    /** Calculate discounts */
    $totalDiscount = 0;
    $coupon = null;
    if (session('coupon')) {
      /** Get coupon */
      $coupon = DiscountCode::findActiveByCode(session('coupon')["name"]);
      $calculatedDiscount = $coupon->getDiscount(Cart::total());
      /** Prepare coupon */
      $discount = floatval(str_replace(',', '.', $calculatedDiscount));
      $temp = floatval(str_replace(',', '.', Cart::total()));
      /** Set coupon values */
      $totalDiscount = $temp - $discount;

      /** Add coupon item */
      $item = [
        'name' => 'Coupon '. session('coupon')["name"],
        'price' => -number_format($discount, 2),
        'qty' => 1,
      ];
      array_push($data['items'], $item);
    }

    /** Loop items to get the total price to pay */
    $total = 0;
    foreach ($data['items'] as $item) {
      $total += $item['price'] * $item['qty'];
    }
    $data['total'] = $total;

    Log::info('Prepared all Paypal data', [$data]);

    /** Create express checkout payment */
    $response = $provider->setExpressCheckout($data);
    Log::info('Prepared checkout. Redirecting to paypal', [$response]);

    /** Create the order and submit the paypal token as it the only common response we know in a further request*/
    $this->createOrder($data, $response["TOKEN"], $request->email, $request->epic_id, $request->discord_id, $random_pin, $request->platform, $request->platform_username, $subtotal, $discount, $coupon);

    /** Redirect the user to Papyal */
    return redirect($response['paypal_link']);
  }

  public function createPaysafecardOrder(Request $request) {
      request()->validate([
          'email' => 'required|email',
          'platform' => 'required|in:PC,PS4,XBOX',
          'epic_id' => 'required|min:3|max:20',
          'discord_id' => 'nullable|regex:/\w+#\d{4}/m',
      ]);

    // create new Payment Controller
    $pscpayment = new Paysafecard("psc_oez5DVLwRRpqLpFQT9cJ0GiTnw0jZC7", "TEST");


    /** Prepare order */
    $random_pin = rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    $invoice_number = Str::uuid();
    $invoice_description = $invoice_number;
    Log::info('Prepare order', [$invoice_number]);

    /** Prepare paysafecard data - KEEP IN SYNC WITH BELOW FUNCTION*/
    $correlation_id = "fortniteShop_" . uniqid();
    $data['items'] = [];
    $data['invoice_id'] = $invoice_number;
    $data['invoice_description'] = $correlation_id;
    $data['custom'] = 'test';
    $data['customer_id'] = md5($request->email);
    $data['customer_ip'] = $_SERVER['REMOTE_ADDR'];
    $data['return_url'] = route('checkout.paysafecard.success', ['invoice_id' => $invoice_number, 'order_pin' => $random_pin]) . '?payment_id={payment_id}';
    $data['cancel_url'] = route('checkout.paysafecard.error');
    $data['notification_url'] = route('checkout.paysafecard.notification', ['invoice_id' => $invoice_number]) . '?payment_id={payment_id}';

    /** Loop all Cart items to create the payment. Use data from model to prevent user modified data*/
    $cart = Cart::content();
    foreach($cart as $cartItem) {
      $item = [
        'name' => $cartItem->model->name,
        'price' => $cartItem->model->price,
        'qty' => $cartItem->qty,
      ];
      array_push($data['items'], $item);
    }

    /** Calclate subtotal before discounts */
    $subtotal = 0;
    $discount = 0;
    foreach ($data['items'] as $item) {
      $subtotal += $item['price'] * $item['qty'];
    }

    /** Calculate discounts */
    $totalDiscount = 0;
    $coupon = null;
    if (session('coupon')) {
      /** Get coupon */
      $coupon = DiscountCode::findActiveByCode(session('coupon')["name"]);
      $calculatedDiscount = $coupon->getDiscount(Cart::total());
      /** Prepare coupon */
      $discount = floatval(str_replace(',', '.', $calculatedDiscount));
      $temp = floatval(str_replace(',', '.', Cart::total()));
      /** Set coupon values */
      $totalDiscount = $temp - $discount;

      /** Add coupon item */
      $item = [
        'name' => 'Coupon '. session('coupon')["name"],
        'price' => -number_format($discount, 2),
        'qty' => 1,
      ];
      array_push($data['items'], $item);
    }

    /** Loop items to get the total price to pay */
    $total = 0;
    foreach ($data['items'] as $item) {
      $total += $item['price'] * $item['qty'];
    }
    $total += round($total * 8/100, 2);
    $totaleur = round($total * 0.871, 2);
    $data['total'] = $total;
    Log::info('Prepared all paysafecard data', [$data]);
    /** Create express checkout payment */
    $response = $pscpayment->createPayment($totaleur, 'EUR', $data['customer_id'], $data['customer_ip'], $data['return_url'], $data['cancel_url'], $data['notification_url'], $correlation_id);
    Log::info('Prepared checkout. Redirecting to paysafecard', [$response]);
    // dd($response);

    /** Create the order and submit the paysafecard token as it the only common response we know in a further request*/
    $this->createOrder($data, $data['invoice_id'], $request->email, $request->epic_id, $request->discord_id, $random_pin, $request->platform, $request->platform_username, $subtotal, $discount, $coupon);
    // dd($response);
    /** Redirect the user to Papyal */
    if (isset($response["object"])) {
        if (isset($response["redirect"])) {
            return redirect($response["redirect"]['auth_url']);
        }
        else {
            return abort(403, 'Transaction could not be initiated due to connection problems. If the problem persists, please contact our support.');
        }
    }
    else {
        return abort(403, 'Transaction could not be initiated due to connection problems. If the problem persists, please contact our support.');
    }
  }

public function paysafecardPaymentSuccessAndPay(Request $request, $invoiceId, $pinCode)
{
    $pscpayment = new Paysafecard("psc_oez5DVLwRRpqLpFQT9cJ0GiTnw0jZC7", "TEST");

    /** Prepare paysafecard data */
      $data['items'] = [];
      $data['payment_id'] = $request->payment_id;
      $data['invoice_id'] = $invoiceId;
      $data['invoice_description'] = $invoiceId;
      $data['custom'] = 'test';
      $data['return_url'] = route('checkout.paysafecard.success', ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]);
      $data['cancel_url'] = route('checkout.paysafecard.error');

      /** Loop all Cart items to create the payment. Use data from model to prevent user modified data*/
      $cart = Cart::content();
      foreach($cart as $cartItem) {
        $item = [
          'name' => $cartItem->model->name,
          'price' => $cartItem->model->price,
          'qty' => $cartItem->qty,
        ];
        array_push($data['items'], $item);
      }

      /** Loop items to get the total price to pay */
      $total = 0;
      foreach ($data['items'] as $item) {
        $total += $item['price'] * $item['qty'];
      }
      $data['total'] = $total;
    /** End prepared data */

    if (isset($data['payment_id'])) {
        $id = $data['payment_id'];
        // get the current payment information
        $response = $pscpayment->retrievePayment($id);
        if ($response == false) {
            // retrieving the payment failed
            // printError($pscpayment, $config['debug_level'], $id);
        } else if (isset($response["object"])) {
            if ($response["status"] == "SUCCESS") {
                // transaction was successful, show customer a positive feedback. Do NOT process any actions here.
                // printSuccess($response, $pscpayment, $config['debug_level']);
                // dd("STATUS SUCCESS CALLED");
                /** Payed - we can destroy the card */
                  Cart::destroy();

                /* Redirect */
                var_dump('Done');

            } else if ($response["status"] == "AUTHORIZED") {
                // capture payment
                $response = $pscpayment->capturePayment($id);

                if ($response == false) {
                    // printError($pscpayment, $config['debug_level'], $id);
                } else if (isset($response["object"])) {
                    if ($response["status"] == "SUCCESS") {
                        //---------------------------------------//
                        /*
                        *                Payment OK
                        *        Here you can save the Payment
                        * process your actions here (i.e. send confirmation email etc.)
                        *  This is a fallback to notification.php
                        */
                        //---------------------------------------//
                        // printSuccess($response, $pscpayment, $config['debug_level']);
                        /** Make order paid */
                        $order = Order::findByInvoiceNumber($invoiceId);
                        $order->order_paid = true;
                        $order->payment_gateway = "paysafecard";
                        $order->save();

                        $this->checkCoupon($order);
                        $this->setRef($order);
                        $this->checkItemsForOwned($order);
                        $this->notifyDiscord($order); // localwork
                        $this->updateItems($order);

                        /** Payed - we can destroy the card */
                          Cart::destroy();

                        /** Send email */
                        if($order->accounts()->count() === 0 && $order->skins()->count() === 0) {
                        $this->sendConfirmationMail($order->email, route('checkout.paysafecard.invoice',  ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]));
                        }
                        else if ($order->accounts()->count() > 0 || $order->skins()->count() > 0) {
                        $this->sendConfirmationMailDetails($order->email, route('checkout.paysafecard.invoice',  ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]), $order);
                        }

                    } else {
                        if ($response["number"] == 2017) {
                            // check with retrieve Payment details if the payment is successful or not
                            $response = $pscpayment->retrievePayment($id);

                            if (isset($response["status"])) {

                                if ($response["status"] == "SUCCESS") {
                                    // transaction was successful, show customer a positive feedback. Do NOT process any actions here.
                                    // printSuccess($response, $pscpayment, $config['debug_level']);
                                    /** Payed - we can destroy the card */
                                    // dd("NUMBER 2017 STATUS SUCCESS CALLED");
                                      Cart::destroy();

                                    /* Redirect */
                                    var_dump('Done');

                                } else {
                                    // printError($pscpayment, $config['debug_level'], $id);
                                }
                            } else {
                                // printError($pscpayment, $config['debug_level'], $id);
                            }
                        }
                    }
                }
            }
        }
    }

    /* Redirect */
    return redirect(route('checkout.paysafecard.invoice',  ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]));

}

    public function paysafecardNotification(Request $request)
    {
        // create new Payment Controller
        $pscpayment = new Paysafecard("psc_oez5DVLwRRpqLpFQT9cJ0GiTnw0jZC7", "TEST");
        // checking for actual action
        if (isset($_GET["payment_id"])) {
            $id = $_GET["payment_id"];
            // get payment status with retrieve Payment details
            $response = $pscpayment->retrievePayment($id);
            // $logger->log($pscpayment->getRequest(), $pscpayment->getCurl(), $pscpayment->getResponse());
            if ($response == true) {
                if (isset($response["object"])) {
                    if ($response["status"] == "AUTHORIZED") {
                        // capture payment
                        $response = $pscpayment->capturePayment($id);
                        $error    = $pscpayment->getError();
                        // $logger->log($pscpayment->getRequest(), $pscpayment->getCurl(), $pscpayment->getResponse());
                        if ($response == true) {
                            if (isset($response["object"])) {
                                if ($response["status"] == "SUCCESS") {

                                    //---------------------------------------//
                                    /*
                                     *                Payment OK
                                     *        Here you can save the Payment
                                     * process your actions here (i.e. send confirmation email etc.)
                                     */
                                    //---------------------------------------//

                                    $order = Order::findByInvoiceNumber($invoiceId);
                                    $order->order_paid = true;
                                    $order->payment_gateway = "paysafecard";
                                    $order->save();

                                    $this->checkCoupon($order);
                                    $this->setRef($order);
                                    $this->notifyDiscord($order); // localwork
                                    $this->updateItems($order);

                                    /** Payed - we can destroy the card */
                                      Cart::destroy();

                                    /** Send email */
                                    if($order->accounts()->count() === 0 && $order->skins()->count() === 0) {
                                    $this->sendConfirmationMail($order->email, route('checkout.paysafecard.invoice',  ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]));
                                    }
                                    else if ($order->accounts()->count() > 0 || $order->skins()->count() > 0) {
                                    $this->sendConfirmationMailDetails($order->email, route('checkout.paysafecard.invoice',  ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]), $order);
                                    }

                                }
                            }
                        }
                    }
                }
            }
        }
    }

  /** Make payment */
  public function paypalPaymentSuccessAndPay(Request $request, $invoiceId, $pinCode) {
    /** Get paypal provider */
    $provider = $this->preparePaypalProvider();

    /** Prepare actual payment */
    $token = $request->get('token');
    $PayerID = $request->get('PayerID');

    /** Prepare paypal data */
      $data['items'] = [];
      $data['invoice_id'] = $invoiceId;
      $data['invoice_description'] = $invoiceId;
      $data['custom'] = 'test';
      $data['return_url'] = route('checkout.paypal.success', ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]);
      $data['cancel_url'] = route('checkout.paypal.error');

      /** Loop all Cart items to create the payment. Use data from model to prevent user modified data*/
      $cart = Cart::content();
      foreach($cart as $cartItem) {
        $item = [
          'name' => $cartItem->model->name,
          'price' => $cartItem->model->price,
          'qty' => $cartItem->qty,
        ];
        array_push($data['items'], $item);
      }

      /** Loop items to get the total price to pay */
      $total = 0;
      foreach ($data['items'] as $item) {
        $total += $item['price'] * $item['qty'];
      }
      $data['total'] = $total;
    /** End prepared data */

    /*** Verfiy express checkout token */
    $response = $provider->getExpressCheckoutDetails($token);

    if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
      $payment_status = $provider->doExpressCheckoutPayment($data, $token, $PayerID);
      $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
      /** Here completed already comes back so we need to act on it */
      if ($status === 'Completed') {
        /** Make order paid */
        $order = Order::findByInvoiceNumber($invoiceId);
        $order->order_paid = true;
        $order->payment_gateway = "PayPal";
        $order->save();

        $this->checkCoupon($order);
        $this->setRef($order);
        $this->checkItemsForOwned($order);
        $this->notifyDiscord($order); // localwork
        $this->notifyUser($order);
        $this->updateItems($order);

        /** Send email */
        if($order->accounts()->count() === 0 && $order->skins()->count() === 0) {
            $this->sendConfirmationMail($order->email, route('checkout.paypal.invoice',  ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]));
        }
        else if ($order->accounts()->count() > 0 || $order->skins()->count() > 0) {
            $this->sendConfirmationMailDetails($order->email, route('checkout.paypal.invoice',  ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]), $order);
        }
        }
    }
    /** Payed - we can destroy the card */
      Cart::destroy();

    /* Redirect */
    return redirect(route('checkout.paypal.invoice',  ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]));
  }

  /**
  * Mollie Payment Method
  */
  public function createMollieOrder(Request $request) {

      request()->validate([
          'email' => 'required|email',
          'platform' => 'required|in:PC,PS4,XBOX',
          'epic_id' => 'required|min:3|max:20',
          'discord_id' => 'nullable|regex:/\w+#\d{4}/m',
      ]);

    /** Prepare order */
    $random_pin = rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    $invoice_number = Str::uuid();
    $invoice_description = $invoice_number;
    Log::info('Prepare order', [$invoice_number]);

    /** Prepare paysafecard data - KEEP IN SYNC WITH BELOW FUNCTION*/
    $data['items'] = [];
    $data['invoice_id'] = $invoice_number;
    $data['invoice_description'] = $invoice_number;
    $data['custom'] = 'test';
    $data['customer_id'] = md5($request->email);
    $data['customer_ip'] = $_SERVER['REMOTE_ADDR'];
    $data['return_url'] = route('checkout.mollie.invoice',  ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]);
    $data['cancel_url'] = route('checkout.paysafecard.error');
    $data['notification_url'] = route('checkout.mollie.notification', ['invoice_id' => $invoice_number]);

    /** Loop all Cart items to create the payment. Use data from model to prevent user modified data*/
    $cart = Cart::content();
    foreach($cart as $cartItem) {
      $item = [
        'name' => $cartItem->model->name,
        'price' => $cartItem->model->price,
        'qty' => $cartItem->qty,
      ];
      array_push($data['items'], $item);
    }

    /** Calclate subtotal before discounts */
    $subtotal = 0;
    $discount = 0;
    foreach ($data['items'] as $item) {
      $subtotal += $item['price'] * $item['qty'];
    }

    /** Calculate discounts */
    $totalDiscount = 0;
    $coupon = null;
    if (session('coupon')) {
      /** Get coupon */
      $coupon = DiscountCode::findActiveByCode(session('coupon')["name"]);
      $calculatedDiscount = $coupon->getDiscount(Cart::total());
      /** Prepare coupon */
      $discount = floatval(str_replace(',', '.', $calculatedDiscount));
      $temp = floatval(str_replace(',', '.', Cart::total()));
      /** Set coupon values */
      $totalDiscount = $temp - $discount;

      /** Add coupon item */
      $item = [
        'name' => 'Coupon '. session('coupon')["name"],
        'price' => -number_format($discount, 2),
        'qty' => 1,
      ];
      array_push($data['items'], $item);
    }

    /** Loop items to get the total price to pay */
    $total = 0;
    foreach ($data['items'] as $item) {
      $total += $item['price'] * $item['qty'];
    }

    $data['total'] = $total;
    Log::info('Prepared all Mollie data', [$data]);
    /** Create express checkout payment */
    $payment = Mollie::api()->payments()->create([
        'amount' => [
            'currency' => 'USD',
            'value' => (string)$data['total'],
        ],
        'description' => 'fortnitemall.gg - ' . $data['invoice_id'],
        'redirectUrl' => $data['return_url'],
        'webhookUrl' => $data['notification_url'],
        'method' => $request->payment_method,
    ]);
    Log::info('Prepared checkout. Redirecting to Mollie', [$payment]);
    // dd($response);

    /** Create the order and submit the paysafecard token as it the only common response we know in a further request*/
    $this->createOrder($data, $data['invoice_id'], $request->email, $request->epic_id, $request->discord_id, $random_pin, $request->platform, $request->platform_username, $subtotal, $discount, $coupon);
    // dd($response);
    /** Redirect the user to Mollie */
    $payment = Mollie::api()->payments()->get($payment->id);

    // redirect customer to Mollie checkout page
    return redirect($payment->getCheckoutUrl(), 303);
}
  /**
  * Wallet Payment Method
  */
  public function createWalletOrder(Request $request) {
      request()->validate([
          'email' => 'required|email',
          'platform' => 'required|in:PC,PS4,XBOX',
          'epic_id' => 'required|min:3|max:20',
          'discord_id' => 'nullable|regex:/\w+#\d{4}/m',
      ]);
    /** Prepare order */
    $random_pin = rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    $invoice_number = Str::uuid();
    $invoice_description = $invoice_number;
    Log::info('Prepare order', [$invoice_number]);

    /** Prepare paysafecard data - KEEP IN SYNC WITH BELOW FUNCTION*/
    $data['items'] = [];
    $data['invoice_id'] = $invoice_number;
    $data['invoice_description'] = $invoice_number;

    /** Loop all Cart items to create the payment. Use data from model to prevent user modified data*/
    $cart = Cart::content();
    foreach($cart as $cartItem) {
      $item = [
        'name' => $cartItem->model->name,
        'price' => $cartItem->model->price,
        'qty' => $cartItem->qty,
      ];
      array_push($data['items'], $item);
    }

    /** Calclate subtotal before discounts */
    $subtotal = 0;
    $discount = 0;
    foreach ($data['items'] as $item) {
      $subtotal += $item['price'] * $item['qty'];
    }

    /** Calculate discounts */
    $totalDiscount = 0;
    $coupon = null;
    if (session('coupon')) {
      /** Get coupon */
      $coupon = DiscountCode::findActiveByCode(session('coupon')["name"]);
      $calculatedDiscount = $coupon->getDiscount(Cart::total());
      /** Prepare coupon */
      $discount = floatval(str_replace(',', '.', $calculatedDiscount));
      $temp = floatval(str_replace(',', '.', Cart::total()));
      /** Set coupon values */
      $totalDiscount = $temp - $discount;

      /** Add coupon item */
      $item = [
        'name' => 'Coupon '. session('coupon')["name"],
        'price' => -number_format($discount, 2),
        'qty' => 1,
      ];
      array_push($data['items'], $item);
    }

    /** Loop items to get the total price to pay */
    $total = 0;
    foreach ($data['items'] as $item) {
      $total += $item['price'] * $item['qty'];
    }

    $data['total'] = $total;

    /** Create the order and submit the paysafecard token as it the only common response we know in a further request*/
    $this->createOrder($data, $data['invoice_id'], $request->email, $request->epic_id, $request->discord_id, $random_pin, $request->platform, $request->platform_username, $subtotal, $discount, $coupon);

    $user = Auth::user();
    $wallet = $user->wallet;

    if($wallet->canWithdraw($total)) {
        $wallet->withdraw($total);
        $invoice_number = Str::uuid();
        $transaction = $wallet->transactions()
            ->create([
                'amount' => $total,
                'invoice_number' => $invoice_number,
                'type' => 'withdraw',
                'meta' => [
                    'oldBalance' => ($wallet->balance - $total)
                ],
            ]);
        $order = Order::findByInvoiceNumber($data['invoice_id']);
        $order->order_paid = true;
        $order->payment_gateway = 'Wallet';
        $order->save();

        $this->checkCoupon($order);
        $this->setRef($order);
        $this->checkItemsForOwned($order);
        $this->notifyDiscord($order); // localwork

        /** Payed - we can destroy the card */
        Cart::destroy();

        /** Send email */
        $this->sendConfirmationMail($order->email, route('checkout.wallet.invoice',  ['invoice_id' => $order->invoice_number, 'order_pin' => $order->order_password]));

        /* Redirect */
        return redirect(route('checkout.wallet.invoice',  ['invoice_id' => $order->invoice_number, 'order_pin' => $order->order_password]));
    }
    else {
        $order = Order::findByInvoiceNumber($data['invoice_id']);
        $order->order_paid = false;
        $order->order_failed = true;
        $order->payment_gateway = 'Wallet';
        $order->save();
        return redirect()->back()->with('insufficient-funds', true);
    }

    // redirect customer to Mollie checkout page
    return redirect($payment->getCheckoutUrl(), 303);
}

    public function mollieNotification(Request $request, $invoiceId) {
        if (!$request->has('id')) {
            return;
        }

        $payment = Mollie::api()->payments()->get($request->id);

        if($payment->isPaid()) {
            $order = Order::findByInvoiceNumber($invoiceId);
            $order->order_paid = true;
            $order->payment_gateway = $payment->get('method');
            $order->save();

            $this->checkCoupon($order);
            $this->setRef($order);
            $this->checkItemsForOwned($order);
            $this->notifyDiscord($order); // localwork

            /** Payed - we can destroy the card */
            Cart::destroy();

            /** Send email */
            $this->sendConfirmationMail($order->email, route('checkout.mollie.invoice',  ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]));

            /* Redirect */
            return redirect(route('checkout.mollie.invoice',  ['invoice_id' => $invoiceId, 'order_pin' => $pinCode]));
        }
    }

  /**
  * Update the Items to active FALSE and is_sold TRUE.
  */
  public function updateItems($order)
  {
      if($order->accounts()->count() > 0)
      {
          foreach ($order->accounts as $account) {
              $account->active = false;
              $account->is_sold = true;
              $account->save();
          }
      }

      if($order->skins()->count() > 0)
      {
          foreach ($order->skins as $skin) {
              $skin->active = false;
              $skin->is_sold = true;
              $skin->save();
          }
      }
  }


  /**
   * Notifiy discord about payment
   */
  public function notifyDiscord($order) {
    $client = new \GuzzleHttp\Client();
    $discord = new Discord($client, 'DISCORD_BOT_TOKEN');
    /*$discord->send('561294901484978186', [
      'content' =>
        '<@&561959263635767347> | ' .
        '**Order** #' . $order->invoice_number . ' | ' .
        '**Email** ' . $order->email . ' | ' .
        '**EPIC-ID** ' . $order->epic_id . ' | ' .
        '**Platform** ' . $order->platform . ' | ' .
        '**Discord** ' . $order->discord_id . ' | ' .
        '**Order PIN** ' . $order->order_password . ' | ' .
        '**Order Paid** ' . ($order->order_paid ? 'Yes' : 'No') . ' | ' .
        '**Amount paid** USD ' . number_format($order->total, 2) . ' | ' .
        '**Details** ' . route('checkout.paypal.invoice',  ['invoice_id' => $order->invoice_number, 'order_pin' => $order->order_password])
    ]);*/
    $accountDetails = '';
    if($order->accounts()->count() > 0)
    {
        $i = 1;
        $accountDetail = '';
        foreach($order->accounts as $account)
        {
            $accountDetail = $accountDetail . PHP_EOL . '**Account #' . $i . '**' . ' https://fortnitemall.gg/nova/resources/accounts/' . $account->id;
            $i++;
        }
        $accountDetails = PHP_EOL . '**Accounts Details**' . $accountDetail;
    }
    $skinDetails = '';
    if($order->skins()->count() > 0)
    {
        $i = 1;
        $skinDetail = '';
        foreach($order->skins as $skin)
        {
            $skinDetail = $skinDetail . PHP_EOL . '**Skin #' . $i . '**' . ' https://fortnitemall.gg/nova/resources/skins/' . $skin->id;
            $i++;
        }
        $skinDetails = PHP_EOL . '**Skins Details**' . $skinDetail;
    }
    $platformUsername = '';
    if(!is_null($order->platform_username)) {
        if($order->platform === "PS4") {
            $platformUsername = '**PS4 Nickname** ' . $order->platform_username . PHP_EOL;
        }
        if($order->platform === "XBOX") {
            $platformUsername = '**XBOX Nickname** ' . $order->platform_username . PHP_EOL;
        }
    }
    $paymentGatewayLower = strtolower($order->payment_gateway);
	$discord->send('570535390415683586', [
      'content' =>
        '<@&570556871182909441> ' . PHP_EOL .
        '**Order** #' . $order->invoice_number . ' ; ' . '**Password** ' . $order->order_password . PHP_EOL .
        (is_null($order->user) ? '' : '**User** ' . $order->user->name . PHP_EOL) .
        '**Email** ' . $order->email . PHP_EOL .
        '**EPIC-ID** ' . $order->epic_id . PHP_EOL .
        '**Platform** ' . $order->platform . PHP_EOL .
        $platformUsername .
        (is_null($order->discord_id) ? '' : '**Discord** ' . $order->discord_id . PHP_EOL) . //'**Discord** ' . (is_null($order->discord_id) ? '-' : $order->discord_id) . PHP_EOL .
        '**Order Paid** ' . ($order->order_paid ? 'Yes' : 'No') . PHP_EOL .
        '**Amount paid** USD ' . number_format($order->total, 2) . PHP_EOL .
        '**Payment method** ' . $order->payment_gateway . PHP_EOL .
        (is_null($order->referrer_id) ? '' : '**Referred By** ' . User::findOrFail($order->referrer_id)->name . PHP_EOL) .
        '**Details** ' . route("checkout.{$paymentGatewayLower}.invoice",  ['invoice_id' => $order->invoice_number, 'order_pin' => $order->order_password]) .
        $accountDetails .
        $skinDetails
    ]);

  }

  /**
   * Create an order in our system
   */
  public function createOrder($data, $paypalToken, $email, $epic_id, $discord_id, $randomPin, $platform, $platform_username, $subtotal, $discount, $coupon = null) {
    Log::info('Save order');

    $order = new Order();
    $order->email = $email;
    $order->platform = $platform;
    $order->platform_username = $platform_username;
    $order->epic_id = $epic_id;
    $order->discord_id = $discord_id;
    $order->invoice_number = $data["invoice_id"];
    $order->invoice_description = $data["invoice_description"];
    $order->paypal_token = $paypalToken;
    $order->subtotal = $subtotal;
    $order->discount = $discount;
    if(!is_null($coupon)) {
        $order->discount_code_id = $coupon->id;
    }
    if (Auth::user()) {
      $order->user_id = Auth::user()->id;
    }
    $order->total = $data['total'];
    $order->order_password = $randomPin;
    $order->save();

    /** Create order articles */
    $this->createOrderArticles($order);

    Log::info('Order saved', [$order]);
  }

  /** Create the relationship between articles and orders */
  public function createOrderArticles(Order $order) {
    Log::info('Save order articles');

    /** Get cart content */
    $cart = Cart::content();

    /** Loop all items and attach the article to the order */
    foreach($cart as $cartItem) {
        if(class_basename($cartItem->model) === "Article")
        {
            $order
                ->articles()
                    ->attach($cartItem->model->id, [
                        'quantity' => $cartItem->qty,
                        'price_per_unit' => $cartItem->model->price,
                        'subtotal' => $cartItem->model->price * $cartItem->qty,
                        'name' => $cartItem->model->name,
                    ]);
        }

        if(class_basename($cartItem->model) === "Account")
        {
            $order
                ->accounts()
                    ->attach($cartItem->model->id, [
                        'quantity' => $cartItem->qty,
                        'price_per_unit' => $cartItem->model->price,
                        'subtotal' => $cartItem->model->price * $cartItem->qty,
                        'name' => $cartItem->model->name,
                    ]);
        }

        if(class_basename($cartItem->model) === "Skin")
        {
            $order
                ->skins()
                    ->attach($cartItem->model->id, [
                        'quantity' => $cartItem->qty,
                        'price_per_unit' => $cartItem->model->price,
                        'subtotal' => $cartItem->model->price * $cartItem->qty,
                        'name' => $cartItem->model->name,
                    ]);
        }
    }
    Log::info('Finished saving order articles');
  }

  public function sendConfirmationMail($email, $link) {
    Mail::send([], [], function (Message $message) use ($email, $link) {
      $message
          ->to($email)
          ->embedData(Sendgrid::sgEncode([
              'personalizations' => [
                  [
                      'dynamic_template_data' => [
                          'url' => $link,
                      ],
                  ],
              ],
              'template_id' => 'd-8563ffdf9102465592d143ce5aac2b94'
          ]), SendgridTransport::SMTP_API_NAME);
    });
  }

  public function sendConfirmationMailAccounts($email, $link, $accounts) {
      $accountDetails = '';
      foreach($accounts as $account)
      {
          $accountDetails = $accountDetails . '<strong>Account name: </strong>' . $account->name . '<br>' . $account->username . ':' . $account->password . '<div>&nbsp;</div>';
      }
    Mail::send([], [], function (Message $message) use ($email, $link, $accountDetails) {
      $message
          ->to($email)
          ->embedData(Sendgrid::sgEncode([
              'personalizations' => [
                  [
                      'dynamic_template_data' => [
                          'url' => $link,
                          'account' => $accountDetails,
                      ],
                  ],
              ],
              'template_id' => 'd-91dac152148b4b8eac9a89be05d15ccd'
          ]), SendgridTransport::SMTP_API_NAME);
    });
  }

  public function sendConfirmationMailDetails($email, $link, $order) {
      $itemDetails = '';
      if($order->accounts()->count() > 0) {
          $itemDetails = 'Your account details:<br><br>';
          foreach($order->accounts as $item)
          {
              $itemDetails = $itemDetails . '<strong>Account name: </strong>' . $item->name . '<br>' . $item->username . ':' . $item->password . '<div>&nbsp;</div>';

          }
          $itemDetails = $itemDetails . '<br><br>';
      }
      if($order->skins()->count() > 0) {
          $itemDetails = $itemDetails . 'Your skin details:<br><br>';
          foreach($order->skins as $item)
          {
              $itemDetails = $itemDetails . '<strong>Skin name: </strong>' . $item->name . '<br>' . '<strong>Code: </strong>' . ':' . $item->code . '<div>&nbsp;</div>';
          }
      }

    Mail::send([], [], function (Message $message) use ($email, $link, $itemDetails) {
      $message
          ->to($email)
          ->embedData(Sendgrid::sgEncode([
              'personalizations' => [
                  [
                      'dynamic_template_data' => [
                          'url' => $link,
                          'item' => $itemDetails,
                      ],
                  ],
              ],
              'template_id' => 'd-91dac152148b4b8eac9a89be05d15ccd'
          ]), SendgridTransport::SMTP_API_NAME);
    });
  }

    public function checkCoupon($order)
    {
        // dd($order->discountcode);
        if(!is_null($order->discountcode)) {
            // dd($order->discountcode()->user());
            if(!is_null($referred_by) && ($referred_by === Auth::user()->id || User::findOrFail($referred_by)->email === $order->email || User::findOrFail($referred_by)->epic_id === $order->epic_id)) {
                $referred_by = null;
            }
            if($order->discountcode->user()->exists()) {
                // dd($order->discountcode()->user());
                $contributor = $order->discountcode->user;
                if(!is_null($contributor) && ($contributor->id === Auth::user()->id || $contributor->email === $order->email || $contributor->epic_id === $order->epic_id)) {
                    return;
                }
                $amount = with(new DiscountCode)->getRevenue($order->discountcode);
                $amount = $order->total * $amount / 100;
                $invoice_number = Str::uuid();
                $wallet = $contributor->wallet;
                $wallet->deposit($amount);
                $transaction = $wallet->transactions()
                    ->create([
                        'amount' => $amount,
                        'invoice_number' => $invoice_number,
                        'type' => 'revenue',
                        'meta' => [
                            'oldBalance' => ($wallet->balance - $amount),
                            'buyerEpic' => $order->epic_id,
                            'total' => $order->total
                        ],
                    ]);
                if($order->discountcode->onetime) {
                    $order->discountcode->active = false;
                    $order->discountcode->save();
                }
            }
        }
    }

    public function setRef($order)
    {
        $cookie = \Cookie::get('referral');
        $referred_by = $cookie ? \Hashids::decode($cookie)[0] : null;
        if(!is_null($referred_by) && ($referred_by === Auth::user()->id || User::findOrFail($referred_by)->email === $order->email || User::findOrFail($referred_by)->epic_id === $order->epic_id)) {
            $referred_by = null;
        }
        $order->referrer_id = $referred_by;
        $order->save();

        if (!is_null($referred_by)) {
            $referrer = User::findOrFail($referred_by);
            $totalSum = Order::where('order_paid', true)->where('order_delievered', true)->where('referrer_id', $referred_by)->sum('total');
            if($totalSum < 5000) {
                $revenue = 2;
            } elseif ($totalSum >= 5000 && $totalSum < 10000) {
                $revenue = 2.5;
            } elseif ($totalSum >= 10000 && $totalSum < 15000) {
                $revenue = 3;
            } elseif ($totalSum >= 15000 && $totalSum < 25000) {
                $revenue = 4;
            } elseif ($totalSum >= 25000) {
                $revenue = 5;
            }

            $amount = $order->total * $revenue / 100;
            $invoice_number = Str::uuid();
            $wallet = $referrer->wallet;
            $wallet->deposit($amount);
            $transaction = $wallet->transactions()
                ->create([
                    'amount' => $amount,
                    'invoice_number' => $invoice_number,
                    'type' => 'referral',
                    'meta' => [
                        'oldBalance' => ($wallet->balance - $amount),
                        'buyerEpic' => $order->epic_id,
                        'total' => $order->total
                    ],
                ]);
        }
    }

    public function notifyUser($order)
    {
        $user = $order->user;
        if(!is_null($user)) {
            $paymentGatewayLower = strtolower($order->payment_gateway);
            $details = [
                'status' => 'Order Paid',
                'date' => $order->updated_at,
                'payment_gateway' => $order->payment_gateway,
                'invoice_id' => $order->invoice_number,
                'password' => $order->order_password,
                'total' => $order->total,
                'url' => route("checkout.{$paymentGatewayLower}.invoice",  ['invoice_id' => $order->invoice_number, 'order_pin' => $order->order_password]),
            ];

            $user->notify(new OrderPaid($details));
        }
    }

    public function checkItemsForOwned($order)
    {
        $articles = $order->articles()->get();
        foreach ($articles as $article) {
            if($article->user()->exists()) {
                $owner = $article->user;
                if(!is_null($owner) && ((Auth::check() && $owner->id === Auth::user()->id) || $owner->email === $order->email || $owner->epic_id === $order->epic_id)) {
                    continue;
                }
                $qty = $article->getOriginal('pivot_quantity');
                $percentage = $article->owner_revenue;
                $totalRev = ($article->price * $percentage / 100) * $qty;
                $wallet = $owner->wallet;
                $invoice_number = Str::uuid();
                $wallet->deposit($totalRev);
                $transaction = $wallet->transactions()
                    ->create([
                        'amount' => $totalRev,
                        'invoice_number' => $invoice_number,
                        'type' => 'item_revenue',
                        'meta' => [
                            'oldBalance' => ($wallet->balance - $totalRev),
                            'buyerEpic' => $order->epic_id,
                            'total' => $order->total
                        ],
                    ]);
            }
        }
    }
}
