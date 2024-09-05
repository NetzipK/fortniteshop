<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Sichikawa\LaravelSendgridDriver\Transport\SendgridTransport;
use Sichikawa\LaravelSendgridDriver\SendGrid;

class NewsController extends Controller
{
    public function sendNews()
    {
        $orderEmails = Order::where('order_paid', true)->get('email')->unique('email')->toArray();
        $counter = 1;
        foreach($orderEmails as $orderEmail) {
            $email = $orderEmail['email'];
            echo($email);
            echo "\r\n";
            $counter++;
            // Mail::send([], [], function (Message $message) use ($email) {
            //   $message
            //       ->to($email)
            //       ->embedData(Sendgrid::sgEncode([
            //           'personalizations' => [],
            //           'template_id' => 'd-4ea0b459ed114d4b820fb2d60df8f894'
            //       ]), SendgridTransport::SMTP_API_NAME);
            // });
            // sleep(1);
        }
        var_dump('Counter: ' . $counter . ' emails found');
    }
}
