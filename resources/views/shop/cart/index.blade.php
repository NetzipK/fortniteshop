@extends('layouts.shop')

@section('siteTitle')
Shopping Cart
@endsection
@section('seo')
<meta name="description" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<meta name="og:title" property="og:title" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<link href="{{Request::url()}}" rel="canonical">
@endsection

@section('pageSpecificCSS')
<link href="{{URL::to('/')}}/assets/css/cartStyle.css" rel="stylesheet" type="text/css">
<link href="{{URL::to('/')}}/assets/css/style.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<section class="content jumbotron jumbotron-video-7" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_33.png); margin-top: 50px; border-bottom: 4px solid #19A5D4;"></section>

<section class="content account">
    <div class="custom-container">
        <h2 style="margin-bottom: 2rem;" class="component-heading text-center">Your fortnitemall.gg <span class="color"> Shopping Cart</span></h2>
        @include('shop.cart.shopping-cart')
    </div>
</section>
<section class="content" style="background: white;">
    <div class="container">
        <h2 style="margin-bottom: 2rem;" class="component-heading text-center">Fortnite items <span class="color"> you may like</span></h2>
        <hr>
    </div>
    @include('shop.partials.featuredProductsRow')
</section>

@endsection
