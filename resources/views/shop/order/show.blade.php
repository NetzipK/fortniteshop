@extends('layouts.shop')

@section('content')
<section class="content jumbotron jumbotron-video-5" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_12.jpg)" style="margin-top: 50px;">
</section>
<section class="content account">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                @include('shop.order.sidebar')
            </div>
            <div class="col-sm-9">
                @include('shop.partials.order-table')
            </div>
        </div> 
    </div>
</section>
@endsection