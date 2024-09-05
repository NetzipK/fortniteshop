<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use NotificationChannels\Discord\Discord;
use App\Cashout;

class CashoutController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index(Request $request)
    {
        $availableCashout = $request->user()->wallet->getCashoutAmount();

        return view('shop.cashout.index', compact('availableCashout'));
    }

    public function requestCashout(Request $request)
    {
        $request->user()->authorizeRoles(['Test Supplier', 'Supplier', 'Contributor', 'Distributor']);

        if(!$request->user()->cashouts()->where('accepted', null)->count() > 0) {
            $amount = $request->get('amount');
            $paypal = $request->get('paypal');
            $currency = \Cookie::get('Currency', 'USD');

            if($request->user()->wallet->getCashoutAmount() >= $amount) {
                $wallet = $request->user()->wallet;
                $invoice_number = Str::uuid();
                $wallet->withdraw($amount);
                $transaction = $wallet->transactions()
                    ->create([
                        'amount' => $amount,
                        'invoice_number' => $invoice_number,
                        'type' => 'cashout',
                        'meta' => [
                            
                        ],
                    ]);
                $cashout = $request->user()->cashouts()
                    ->create([
                        'amount' => $amount,
                        'currency' => $currency,
                        'paypal' => $paypal,
                    ]);

                $this->notifyDiscord($cashout);
            } else {
                // dd('Not enough funds');
                return redirect()->back()->with('no-funds', true);
            }
        } else {
            // dd('Already requested cashout');
            return redirect()->back()->with('already-req', true);
        }
        return redirect()->back();
    }

    public function acceptCashout(Request $request)
    {
        $user = $request->get('user');
        $cashout = Cashout::findByUser($user);
        // dd($cashout);
        if(!is_null($cashout)) {
            $cashout->accepted = true;
            $cashout->save();
            return "200";
        } else {
            return "400";
        }
    }

    public function denyCashout(Request $request)
    {
        $user = $request->get('user');
        $cashout = Cashout::findByUser($user);

        if(!is_null($cashout)) {
            $cashout->accepted = false;
            $cashout->save();
            $wallet = $cashout->user->wallet;
            $amount = $cashout->amount;
            $wallet->deposit($amount);
            return "200";
        } else {
            return "400";
        }
    }

    public function notifyDiscord($cashout) {
      $client = new \GuzzleHttp\Client();
      $discord = new Discord($client, 'DISCORD_BOT_TOKEN');
      $user = $cashout->user;
      if($user->hasRole('Distributor')) {
          $role = 'Distributor';
      }
      if($user->hasRole('Contributor')) {
          $role = 'Contributor';
      }
      if($user->hasRole('Test Supplier')) {
          $role = 'Test Supplier';
      }
      if($user->hasRole('Supplier')) {
          $role = 'Supplier';
      }
  	  $discord->send('594854110424072218', [
        'content' =>
          '<@&570539755045912594> ' . PHP_EOL .
          (is_null($cashout->user) ? '' : '**User** ' . $cashout->user->name . PHP_EOL) .
          '**User Type** ' . $role . PHP_EOL .
          '**Amount** ' . number_format($cashout->amount, 2) . PHP_EOL .
          '**Currency** ' . $cashout->currency . PHP_EOL .
          '**PayPal** ' . $cashout->paypal
      ]);

    }
}
