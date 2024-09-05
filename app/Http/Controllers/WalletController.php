<?php

namespace App\Http\Controllers;

use App\Wallet;
use Srmklive\PayPal\Services\ExpressCheckout;
use NotificationChannels\Discord\Discord;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use App\Paysafecard;
use Mollie\Laravel\Facades\Mollie;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $wallet = $user->wallet;
        // if(!$wallet->exists()) {
        //     $wallet = Wallet::create();
        //     $user->attach($wallet->id);
        //     $wallet = $user->wallet();
        // }
        return view('shop.wallet.index', compact('wallet'));
    }

    public function addFunds(Request $request)
    {
        $amount = $request->get('amount');
        $data['total'] = $request->get('amount');
        $data['invoice_id'] = Str::uuid();
        $data['invoice_description'] = "Add Funds to Wallet";
        $data['cancel_url'] = route('wallet.error');
        $data['user_id'] = $request->user()->id;
        $data['items'] = [
            [
                'name' => 'Add Funds ' . $data['total'] . '$',
                'price' => $data['total'],
                'qty' => 1
            ],
        ];

        $payment_method = $request->get('payment-method');
        $data['payment_method'] = $payment_method;
        // dd($payment_method);
        switch ($payment_method) {
            case 'PayPal':
                return redirect($this->createPaypalOrder($data));
                break;
            case 'paysafecard':
                $data['customer_id'] = md5($request->user()->email);
                $data['customer_ip'] = $_SERVER['REMOTE_ADDR'];
                return $this->createPaysafecardOrder($data);
                break;
            default:
                return $this->createMollieOrder($data);
                break;
        }
    }

    public function notifyDiscord($transaction) {
      $client = new \GuzzleHttp\Client();
      $discord = new Discord($client, 'DISCORD_BOT_TOKEN');
  	  $discord->send('596413919447351308', [
        'content' =>
          '<@&570539755045912594> ' . PHP_EOL .
          '**Order** #' . $transaction->invoice_number . PHP_EOL .
          (is_null($transaction->wallet->user) ? '' : '**User** ' . $transaction->wallet->user->name . PHP_EOL) .
          '**Email** ' . $transaction->wallet->user->email . PHP_EOL .
          '**Order Paid** Yes' . PHP_EOL .
          '**Amount paid** USD ' . number_format($transaction->amount, 2) . PHP_EOL .
          '**Old Balance** USD ' . number_format($transaction->meta['oldBalance'], 2) . PHP_EOL .
          '**New Balance** USD ' . number_format($transaction->wallet->balance, 2) . PHP_EOL .
          '**Payment method** ' . $transaction->meta['paymentMethod'] . PHP_EOL .
          '**Details** https://fortnitemall.gg/nova/resources/transactions/' . $transaction->id
      ]);

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
    public function createPaypalOrder($data)
    {
      Log::info('Creating new paypal order');

      $provider = $this->preparePaypalProvider();

      $data['return_url'] = route('wallet.success.paypal', $data['total']);

      Log::info('Prepared all Paypal data', [$data]);

      /** Create express checkout payment */
      $response = $provider->setExpressCheckout($data);
      // Log::info('Prepared checkout. Redirecting to paypal', [$response]);
      // dd($response);
      /** Redirect the user to Papyal */
      return $response['paypal_link'];
    }

    public function walletPayPalSuccess(Request $request, $amount)
    {
        /** Get paypal provider */
        $provider = $this->preparePaypalProvider();

        /** Prepare actual payment */
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');

        /** Prepare paypal data */
          $data['custom'] = 'test';
          $data['return_url'] = route('wallet.success.paypal', $amount);
          $data['cancel_url'] = route('wallet.error');
          $data['total'] = $amount;
          $data['invoice_description'] = "Add Funds to Wallet";
          $data['invoice_id'] = Str::uuid();
          $data['items'] = [
              [
                  'name' => 'Add Funds ' . $data['total'] . '$',
                  'price' => $data['total'],
                  'qty' => 1
              ],
          ];
        /** End prepared data */
        /*** Verfiy express checkout token */
        $response = $provider->getExpressCheckoutDetails($token);
        // dd($response);
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
          $payment_status = $provider->doExpressCheckoutPayment($data, $token, $PayerID);
          // dd($payment_status);
          $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
          /** Here completed already comes back so we need to act on it */
          if ($status === 'Completed') {
              /** Make order paid */
              $invoice_number = Str::uuid();
              $wallet = auth()->user()->wallet;
              $wallet->deposit($amount);
              $transaction = $wallet->transactions()
                  ->create([
                      'amount' => $amount,
                      'invoice_number' => $invoice_number,
                      'type' => 'deposit',
                      'meta' => [
                          'oldBalance' => ($wallet->balance - $amount),
                          'paymentMethod' => 'PayPal'
                      ],
                  ]);
              $this->notifyDiscord($transaction);
            }
            else {
                dd('Something went wrong');
            }
        }

        /* Redirect */
        return redirect(route('user.wallet'))->with('payment-success', true);
    }

    public function createPaysafecardOrder($data) {
      // create new Payment Controller
      $pscpayment = new Paysafecard("psc_8XV7Y7BXtyaniYpbB-fNzLia4WlG69f", "PRODUCTION");

      /** Prepare paysafecard data - KEEP IN SYNC WITH BELOW FUNCTION*/
      $correlation_id = "fortniteShop_" . uniqid();
      $data['return_url'] = route('wallet.success.paysafecard', ['userID' => $data['user_id'], 'amount' => $data['total']]) . '?payment_id={payment_id}';
      $data['notification_url'] = route('wallet.notification.paysafecard', ['userID' => $data['user_id'], 'amount' => $data['total']]) . '?payment_id={payment_id}';

      $total = $data['total'];
      $total += round($total * 8/100, 2);
      $totaleur = round($total * 0.871, 2);
      $data['total'] = $total;
      /** Create express checkout payment */
      $response = $pscpayment->createPayment($totaleur, 'EUR', $data['customer_id'], $data['customer_ip'], $data['return_url'], $data['cancel_url'], $data['notification_url'], $correlation_id);
      Log::info('Prepared checkout. Redirecting to paysafecard', [$response]);
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

  public function walletPaysafecardSuccess($userID, $amount)
  {
      $pscpayment = new Paysafecard("psc_8XV7Y7BXtyaniYpbB-fNzLia4WlG69f", "PRODUCTION");

      $data['payment_id'] = $_GET["payment_id"];

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
                          $user = \App\User::find($userID);
                          $invoice_number = Str::uuid();
                          $wallet = $user->wallet;
                          $wallet->deposit($amount);
                          $transaction = $wallet->transactions()
                              ->create([
                                  'amount' => $amount,
                                  'invoice_number' => $invoice_number,
                                  'type' => 'deposit',
                                  'meta' => [
                                      'oldBalance' => ($wallet->balance - $amount),
                                      'paymentMethod' => 'paysafecard'
                                  ],
                              ]);
                          $this->notifyDiscord($transaction);
                          return redirect(route('user.wallet'))->with('payment-success', true);

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
                                      $user = \App\User::find($userID);
                                      $invoice_number = Str::uuid();
                                      $wallet = $user->wallet;
                                      $wallet->deposit($amount);
                                      $transaction = $wallet->transactions()
                                          ->create([
                                              'amount' => $amount,
                                              'invoice_number' => $invoice_number,
                                              'type' => 'deposit',
                                              'meta' => [
                                                  'oldBalance' => ($wallet->balance - $amount),
                                                  'paymentMethod' => 'paysafecard'
                                              ],
                                          ]);
                                      $this->notifyDiscord($transaction);
                                      return redirect(route('user.wallet'))->with('payment-success', true);

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
      return redirect(route('user.wallet'))->with('payment-success', true);

  }

      public function paysafecardNotification($userID, $amount)
      {
          // create new Payment Controller
          $pscpayment = new Paysafecard("psc_8XV7Y7BXtyaniYpbB-fNzLia4WlG69f", "PRODUCTION");
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
                                      $user = \App\User::find($userID);
                                      $invoice_number = Str::uuid();
                                      $wallet = $user->wallet;
                                      $wallet->deposit($amount);
                                      $transaction = $wallet->transactions()
                                          ->create([
                                              'amount' => $amount,
                                              'invoice_number' => $invoice_number,
                                              'type' => 'deposit',
                                              'meta' => [
                                                  'oldBalance' => ($wallet->balance - $amount),
                                                  'paymentMethod' => 'paysafecard'
                                              ],
                                          ]);
                                      $this->notifyDiscord($transaction);
                                  }
                              }
                          }
                      }
                  }
              }
          }
      }

      public function createMollieOrder($data) {

        $data['return_url'] = route('wallet.success.mollie');
        $data['notification_url'] = route('wallet.notification.mollie', ['userID' => $data['user_id'], 'amount' => $data['total']]);

        $total = $data['total'];
        $totaleur = round($total * 0.877, 2);

        /** Create express checkout payment */
        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => (string)$totaleur,
            ],
            'description' => 'fortnitemall.gg - ' . $data['invoice_id'],
            'redirectUrl' => $data['return_url'],
            'webhookUrl' => $data['notification_url'],
            'method' => $data['payment_method'],
        ]);
        Log::info('Prepared checkout. Redirecting to Mollie', [$payment]);
        // dd($response);
        /** Redirect the user to Mollie */
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function mollieNotification(Request $request, $userID, $amount) {
        if (!$request->has('id')) {
            return;
        }

        $payment = Mollie::api()->payments()->get($request->id);

        if($payment->isPaid()) {
            $user = \App\User::find($userID);
            $invoice_number = Str::uuid();
            $wallet = $user->wallet;
            $wallet->deposit($amount);
            $transaction = $wallet->transactions()
                ->create([
                    'amount' => $amount,
                    'invoice_number' => $invoice_number,
                    'type' => 'deposit',
                    'meta' => [
                        'oldBalance' => ($wallet->balance - $amount),
                        'paymentMethod' => 'Mollie'
                    ],
                ]);
            $this->notifyDiscord($transaction);
        }
    }

    public function walletSuccessMollie()
    {
        return view('shop.user.wallet')->with('payment-success-mollie');
    }

    public function walletError(Request $request)
    {
        return view('shop.user.wallet')->with('payment-error', true);
    }
}
