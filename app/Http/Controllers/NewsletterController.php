<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $email = $request->get('email');

        if(!Newsletter::isSubscribed($email)) {
            Newsletter::subscribe($email);
        }

        return redirect()->back()->with('modalPopup', 'Thanks for subscribing!');
    }
}
