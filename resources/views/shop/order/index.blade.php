@extends('layouts.shop')

@section('content')
<section class="content jumbotron jumbotron-video-2" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_06.jpg)" style="margin-top: 50px;">
</section>
<section class="content account">
  <div class="container">
      <div class="row">
        <div class="col-sm-3">
          @include('shop.order.sidebar')
        </div>
          <div class="col-sm-9">
              <article class="account-content">
                  <h3>My Fortnitemall orders ({{$orders->count()}})</h3>
                  <hr>
                  <div class="table-responsive border">
                      <table class="table table-bordered">
                          <tbody><tr>
                              <th class="col-xs-4 text-center">Order ID</th>
                              <th class="col-xs-3 text-center">Date</th>
                              <th class="col-md-1 text-center hidden-xs hidden-sm">Items</th>
                              <th class="col-xs-2 text-center">Total Price</th>
                              <th class="col-xs-3 text-center">Status</th>
                              <th class="col-xs-1 text-center"></th>
                          </tr>
                         @foreach($orders as $order) 
                          <tr>
                              <td class="text-center"><a href="{{route('user.order.show', $order->invoice_number)}}">#{{$order->invoice_number}}</a></td>
                              <td class="text-center">{{$order->created_at}}</td>
                              <td class="text-center hidden-xs hidden-sm">3</td>
                              <td class="text-center">USD {{number_format($order->total, 2)}}</td>
                              <td class="text-center">
                                @if(!$order->order_failed && !$order->order_payed && !$order->order_delievered)
                                  <span class="label label-info">Waiting</span>
                                @endif
                                @if($order->order_failed)
                                  <span class="label label-danger">Failed</span>
                                @endif
                                @if($order->order_paid)
                                  <span class="label label-info">Paid</span>
                                @endif
                                @if($order->order_delievered)
                                  <span class="label label-success">Finished</span>
                                @endif
                              </td>
                              <td><a href="{{route('user.order.show', $order->invoice_number)}}" class="btn btn-primary btn-sm">View</a></td>
                          </tr>
                          @endforeach
                          
                      </tbody></table>
                  </div>
                  <hr>
                  <div>
                    <h4>Status overview</h4>
                    <div style="display: inline; font-size: 13px; color: #adabab;">
                      <div>
                        <span style="font-size: 10px;" class="label label-info">Waiting</span>
                        Your order is currently beeing processed. We are waiting for a response from PayPal.
                      </di>
                      <div>
                        <span style="font-size: 10px;" class="label label-danger">Failed</span>
                        There was an error with your payment. Please try again or contact us.
                      </div>
                      <div>
                        <span style="font-size: 10px;" class="label label-info">Payed</span>
                        We successfully received your payment. We will contact you as soon as possible for your item delievery.
                      </div>
                      <div>
                        <span style="font-size: 10px;" class="label label-success">Finished</span>
                        Your order was successfully paid and delievered. Enjoy your items!
                      </div>
                    </div>
                  </div>
              </article>
          </div>
      </div>
  </div>
</section>
@endsection