@extends('layouts.shop')

@section('content')

@extends('layouts.shop')
@section('content')
<section class="content jumbotron jumbotron-video-6" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_21.jpg)">
</section>
<section class="content account">
    <div class="container">
        <h1 style="margin-bottom: 2rem;" class="component-heading text-center">Oh no! There was an<span class="color"> error!</span></h2>
        <div class="row" style="margin-bottom: 2rem;">
          <div class="col-md-offset-2 col-md-8">
            <div>Either you canceled your payment or there was an error with Paypal!</div>
            <div>Please try again via this link<br><br><a class="btn btn-primary" href="{{route('cart.index')}}">Shopping cart</a></div>
        </div>
    </div>
</section>
@endsection

@endsection