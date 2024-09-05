<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NotificationChannels\Discord\Discord;

class GiftcardController extends Controller
{
    public function index()
    {
        return view('shop.giftcard.index');
    }

    public function create(Request $request)
    {
        $amount = $request->get('amount');
        $giftcardModel = new \App\Giftcard;
        $giftcard = $giftcardModel->createGiftcard($amount);

        $this->notifyDiscord($giftcard);

        return view('shop.giftcard.index');
    }

    public function notifyDiscord($giftcard) {
      $client = new \GuzzleHttp\Client();
      $discord = new Discord($client, 'DISCORD_BOT_TOKEN');
  	  $discord->send('602793000807956480', [
        'content' =>
          '<@&570539755045912594> ' . PHP_EOL .
          '**Giftcard Purchase**' . PHP_EOL .
          (is_null($giftcard->user) ? '' : '**User** ' . $giftcard->user->name . PHP_EOL) .
          '**Email** ' . $giftcard->user->email . PHP_EOL .
          '**Order Paid** Yes' . PHP_EOL .
          '**Giftcard Code** ' . $giftcard->code . PHP_EOL .
          '**Giftcard Amount** USD ' . number_format($giftcard->amount, 2) . PHP_EOL .
          '**Giftcard Expires At** ' . $giftcard->expires_at . PHP_EOL .
          '**Payment method** SoonTM'
      ]);

    }
}
