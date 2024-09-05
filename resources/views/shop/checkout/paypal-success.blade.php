@extends('layouts.shop')

@section('pageSpecificCSS')
<link href="{{URL::to('/')}}/assets/css/invoiceStyle.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<section class="content jumbotron jumbotron-video-6" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_21.jpg)">
</section>
<section class="content account">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="code-border">
                    <p>YOUR ORDER PASSWORD IS:</p>
                    @if($order->order_failed)
                    <span>****</span>
                    @else
                    <span>{{$order->order_password}}</span>
                    @endif
                    <p class="disclaimer">*Please write it down, we will need it to verify you during the delivery process!</p>
                </div>
            </div>
        </div>
        <h1 style="margin-bottom: 2rem;" class="component-heading text-center">Thank you for your<span class="color"> purchase!</span></h2>
        <div class="row" style="margin-bottom: 2rem;">
          <div class="col-md-offset-2 col-md-8">
              @if ($order->articles()->count() > 0)
              <div>We are now processing your order and are waiting for a verification for your Paypal payment. You will receive an email with your order details once the verification is finished and successful.</div>
              <div>Do you want your order delivered as soon as possible? You have several options.</div><br>
              <div><strong>(Option 1)</strong> Contact us with your order number <strong>{{$order->invoice_number}}</strong> via the chatbox at the bottom of the page.</div><br>
              <div><strong>(Option 2 - Recommended)</strong> Contact us on <a class="btn btn-danger btn-sm" href="https://discord.gg/tWMZdRv" target="_blank">Go to discord</a></div><br>
              @endif
              @if ($order->accounts()->count() > 0)
              <div><strong>Your Account Details have been e-mailed to you!</strong></div><br>
              @endif
              @if ($order->skins()->count() > 0)
              <div><strong>Your Skin Details have been e-mailed to you!</strong></div><br>
              @endif
              <div>All relevant information you need are below. See you soon!</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @include('shop.partials.order-table')
            </div>
        </div>
    </div>
</section>
@endsection
