<article class="account-content">
    @if($order->order_failed)
    <div class="alert alert-danger" role="alert">
        <strong>Failed order!</strong> This order failed because {{$order->payment_gateway}} rejected your payment or you canceled it. Please try again.
    </div>
    @endif
    <h3>Order <span>#{{$order->invoice_number}}</span></h3>

    <hr>
    <div class="order-meta">
        <div class="row">
            <div class="col-xs-4">
                {{-- <span class="label label-lg label-warning order-status">Pending Payment</span> --}}
            </div>
            <div class="col-xs-8">
                <ul class="list-inline order-action">
                    <li><a onclick="print_window();" class="btn btn-primary btn-sm">Print order</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <h4>Order status</h4>
                <ul class="list-unstyled">
                    <li><b>Date: </b> {{$order->created_at}}</li>
                    <li><b>Payment method: </b>{{$order->payment_gateway}}</li>
                    <li><b>Status: </b>
                        @if($order->order_refunded)
                            <span class="label label-danger">Refunded</span>
                        @else
                            @if(!$order->order_failed && !$order->order_paid && !$order->order_delievered)
                                <span class="label label-info">Waiting</span>
                            @endif
                            @if($order->order_failed)
                                <span class="label label-danger">Failed</span>
                            @endif
                            @if($order->order_paid)
                            <span class="label label-success">Paid</span>
                            @endif
                            @if($order->order_delievered)
                            <span class="label label-success">Finished</span>
                            @endif
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <h4>Order Details</h4>
                <ul class="list-unstyled">
                    <li><b>Email: </b>{{$order->email}}</li>
                    <li><b>Epic Id: </b>{{$order->epic_id}}</li>
                    <li><b>Discord: </b>{{$order->discord_id}}</li>
                    @if($order->discountcode()->exists())
                        <li><b>Discount Code: </b><span class="label label-info">{{$order->discountcode->code}}</span></li>
                    @endif
                    @if($order->order_failed)
                    <li><b>Order Password: </b><span class="label label-danger">****</span></li>
                    @else
                    <li><b>Order Password: </b><span class="label label-info">{{$order->order_password}}</span></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    <div class="products-order">

        <div class="table-responsive">
            <table class="table table-products">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @if($order->articles->count() > 0)
                    <tr>
                        <td class="col-xs-4 text-center" colspan="5">STW Items</td>
                    </tr>
                    @endif
                    @foreach($order->articles as $article)
                    <tr>
                        <td class="col-xs-1">
                            <img src="{{route('article.image', $article->image_name)}}" alt="Article {{$article->pivot->name}}" class="img-responsive">
                        </td>
                        <td class="col-xs-4 col-md-5">
                            <h4>
                                <a href="{{route('article.show', $article->external_id)}}">
                                    {{$article->amount_step_size}}x {{$article->pivot->name}}
                                </a>
                                <small>The total amount bought is {{$article->amount_step_size * $article->pivot->quantity}}</small>
                            </h4>
                        </td>
                        <td class="col-xs-2 text-center">
                            <span>USD {{number_format($article->pivot->price_per_unit, 2)}}</span>
                        </td>
                        <td class="col-xs-2 col-md-1 text-center"><span><b>{{$article->pivot->quantity}} x {{$article->amount_step_size}} </b></span></td>
                        <td class="col-xs-2 text-center">USD <span><b>{{number_format($article->pivot->subtotal, 2)}}</b></span></td>
                    </tr>
                    @endforeach

                    @if($order->accounts->count() > 0)
                    <tr>
                        <td class="col-xs-4 text-center" colspan="5">Accounts</td>
                    </tr>
                    @endif
                    @foreach($order->accounts as $account)
                    <tr>
                        <td class="col-xs-1">
                            <img src="{{asset('/assets/images/accounts/' . $account->image_name)}}" alt="Account {{$account->pivot->name}}" class="img-responsive">
                        </td>
                        <td class="col-xs-4 col-md-5">
                            <h4>
                                <a href="{{route('account.show', $account->external_id)}}">
                                    1x {{$account->pivot->name}}
                                </a>
                            </h4>
                        </td>
                        <td class="col-xs-2 text-center">
                            <span>USD {{number_format($account->pivot->price_per_unit, 2)}}</span>
                        </td>
                        <td class="col-xs-2 col-md-1 text-center"><span><b>1x </b></span></td>
                        <td class="col-xs-2 text-center">USD <span><b>{{number_format($account->pivot->subtotal, 2)}}</b></span></td>
                    </tr>
                    @endforeach

                    @if($order->skins->count() > 0)
                    <tr>
                        <td class="col-xs-4 text-center" colspan="5">Skins</td>
                    </tr>
                    @endif
                    @foreach($order->skins as $skin)
                    <tr>
                        <td class="col-xs-1">
                            <img src="{{asset('/assets/images/skins/' . $skin->image_name)}}" alt="Skin {{$skin->pivot->name}}" class="img-responsive">
                        </td>
                        <td class="col-xs-4 col-md-5">
                            <h4>
                                <a href="{{route('skin.show', $skin->external_id)}}">
                                    1x {{$skin->pivot->name}}
                                </a>
                            </h4>
                        </td>
                        <td class="col-xs-2 text-center">
                            <span>USD {{number_format($skin->pivot->price_per_unit, 2)}}</span>
                        </td>
                        <td class="col-xs-2 col-md-1 text-center"><span><b>1x </b></span></td>
                        <td class="col-xs-2 text-center">USD <span><b>{{number_format($skin->pivot->subtotal, 2)}}</b></span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <ul class="list-unstyled order-total">
            <li>Subtotal<span>USD {{ number_format($order->subtotal, 2)}}</span></li>
            <li>Discount<span>- USD {{ number_format($order->discount, 2)}}</span></li>
            <li>Total<span class="total">USD {{ number_format($order->total, 2)}}</span></li>
        </ul>
    </div>
</article>
