@extends('shop.user.layout')

@section('content-menu')
<div class="content-menu col-sm-9" id="profile-content">
    <div class="menu-tabs">
        <button class="tablinks active" onclick="openTab(event, 'Orders')" id="defaultOpen">Orders</button>
    </div>

    <div class="tab-content-bg">
        <div class="tabcontent" id="Orders">
            <div class="bg-light table-bg">
                <table class="profile-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Date/Time</th>
                            <th>Payment Method</th>
                            <th>Invoice ID</th>
                            <th>Password</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                @if($order->order_refunded)
                                    <span class="label label-refunded">Refunded</span>
                                @else
                                    @if(!$order->order_failed && !$order->order_delievered)
                                        <span class="label label-waiting">Waiting</span>
                                    @endif
                                    @if($order->order_failed)
                                        <span class="label label-failed">Failed</span>
                                    @endif
                                    @if($order->order_delievered)
                                    <span class="label label-finished">Finished</span>
                                    @endif
                                @endif
                             </td>
                            <td>{{$order->created_at->format('d/m/Y H:i')}}</td>
                            <td>{{$order->payment_gateway}}</td>
                            <td style="font-size: 12px;">{{$order->invoice_number}}</td>
                            <td>{{$order->order_password}}</td>
                            <td>{{number_format($order->total, 2, ',', '.')}}$</td>
                            <td> <a href="{{$order->getLink()}}">View Details</a> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
