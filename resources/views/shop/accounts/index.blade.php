@extends('layouts.shop')

@section('siteTitle')
Fortnite Accounts Shop
@endsection

@section('seo')
<meta name="description" content="Buy amazing Fortnite Accounts at fortnitemall.gg.">
<meta name="og:title" property="og:title" content="Buy amazing Fortnite Accounts at fortnitemall.gg.">
<link href="{{Request::url()}}" rel="canonical">
@endsection

@section('pageSpecificCSS')
<link href="{{URL::to('/')}}/assets/css/style.css" rel="stylesheet" type="text/css">
<link href="{{URL::to('/')}}/assets/css/filterstyle.css" rel="stylesheet" type="text/css">
<link href="{{URL::to('/')}}/assets/css/ion.rangeSlider.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
@if(Route::currentRouteName() === 'accounts.showbr')
<section class="content jumbotron jumbotron-video-7" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_25.png); margin-top: 50px; border-bottom: 4px solid #19A5D4;"></section>
@elseif(Route::currentRouteName() === 'accounts.showstw')
<section class="content jumbotron jumbotron-video-7" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_24.png); margin-top: 50px; border-bottom: 4px solid #19A5D4;"></section>
@endif
<section class="content products">
    <div class="custom-container">
        <!-- <h2 class="component-heading text-center">What time is it? <span class="color">Shopping time!</span></h2>
        <div class="row" style="margin-bottom: 3rem;">
            <p class="text-center text-muted">
                We have everything you can think of! Choose your account. Add it to your cart. Done.
            </p>
        </div> -->
        <div class="row">
            <div class="col-sm-12 text-center">
                @if (Session::has('article-added'))
                    <div class="alert alert-info" role="alert">
                        <strong>Oh yes!</strong>
                        <br>
                        The account was successfully added to your shopping cart.
                        <br>
                        You can view it <a href="{{route('cart.index')}}"><strong>here</strong></a>
                    </div>
                @endif
            </div>
            <div style="width: 22%" class="col-sm-3">
                @include('shop.partials.account-sidebar')
            </div>
                @include('shop.partials.account-filters')
            <div class="col-sm-12 col-lg-12">
                {{-- Articlegrid --}}
                <div class="row grid" id="products">
                    @if($accounts->count() === 0)
                        <div class="text-center">
                            <h3 style="font-family: 'Luckiest Guy'; letter-spacing: 1px; font-size: 2.5rem;"> NOT THE LLAMA YOU'RE LOOKING FOR</h3>
                            <h4>We couldn't find articles for your search. Please try something different.</h4>
                            <img src="{{asset('assets/images/fortnite/llama-wall.png')}}" style="width: 250px;" alt="Nothing found">
                        </div>
                    @endif
                    <div id="all-accounts">
                        <div style="text-align: center; font-size: 18px;"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
                        {{--@foreach($accounts as $account)
                        @component('shop.components.account-grid-item')
                        @slot('account', $account)
                        @endcomponent
                        @endforeach--}}
                    </div>
                </div>

                {{-- Pagination
                @if($accounts->hasMorePages())
                    <div class="pagination-wrapper">
                        {{ $accounts->links() }}
                    </div>
                @endif --}}
            </div>
        </div>
    </div>
</section>
<div style="display:none;">
    <div id="maxLevel">
        {{$accounts->max('account_level')}}
    </div>
    <div id="maxVBucks">
        {{$accounts->max('vbucks')}}
    </div>
    <div id="maxBPLevel">
        {{$accounts->max('battle_pass_level')}}
    </div>
    <div id="maxSkins">
        {{$accounts->max('outfits')}}
    </div>
    <div id="maxPickaxes">
        {{$accounts->max('pickaxes')}}
    </div>
    <div id="maxBackblings">
        {{$accounts->max('back_bling')}}
    </div>
    <div id="maxGliders">
        {{$accounts->max('gliders')}}
    </div>
    <div id="maxDances">
        {{$accounts->max('dances')}}
    </div>
    <div id="maxPrice">
        {{$accounts->max('price')}}
    </div>
</div>
@endsection

@section('pageSpecificJS')
<script src="{{URL::to('/')}}/js/vendor/modernizr-3.7.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="{{URL::to('/')}}/js/vendor/ion.rangeSlider.min.js"></script>
<script>window.jQuery || document.write('<script src="{{URL::to('/')}}/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
<script src="{{URL::to('/')}}/js/plugins.js"></script>
@if(Route::currentRouteName() === 'accounts.showbr')
<script src="{{URL::to('/')}}/assets/js/br-accounts-filter.js"></script>
@elseif(Route::currentRouteName() === 'accounts.showstw')
<script src="{{URL::to('/')}}/assets/js/stw-accounts-filter.js"></script>
@endif
@endsection
