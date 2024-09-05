@extends('layouts.shop')

@section('siteTitle')
Fortnite Skins Shop
@endsection

@section('seo')
<meta name="description" content="Buy amazing Fortnite Skins at fortnitemall.gg.">
<meta name="og:title" property="og:title" content="Buy amazing Fortnite Skins at fortnitemall.gg.">
<link href="{{Request::url()}}" rel="canonical">
@endsection

@section('pageSpecificCSS')
<link href="{{URL::to('/')}}/assets/css/filterstyle.css" rel="stylesheet" type="text/css">
<link href="{{URL::to('/')}}/assets/css/style.css" rel="stylesheet" type="text/css">
<link href="{{URL::to('/')}}/assets/css/ion.rangeSlider.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<section class="content jumbotron jumbotron-video-7" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_26.png); margin-top: 50px; border-bottom: 4px solid #19A5D4;"></section>

<section class="content products">
    <div class="custom-container">
        <!-- <h2 class="component-heading text-center">What time is it? <span class="color">Shopping time!</span></h2>
        <div class="row" style="margin-bottom: 3rem;">
            <p class="text-center text-muted">
                We have everything you can think of! Choose your skin. Add it to your cart. Done.
            </p>
        </div> -->
        <div class="row" >
            <div class="col-sm-12 text-center">
                @if (Session::has('article-added'))
                    <div class="alert alert-info" role="alert">
                        <strong>Oh yes!</strong>
                        <br>
                        The skins was successfully added to your shopping cart.
                        <br>
                        You can view it <a href="{{route('cart.index')}}"><strong>here</strong></a>
                    </div>
                @endif
            </div>
            @include('shop.partials.skin-filters')
            <div class="col-sm-9 col-lg-12">
                {{-- Articlegrid --}}
                <div class="row grid" id="products">
                    @if($skins->count() === 0)
                        <div class="text-center">
                            <h3 style="font-family: 'Luckiest Guy'; letter-spacing: 1px; font-size: 2.5rem;"> NOT THE LLAMA YOU'RE LOOKING FOR</h3>
                            <h4>We couldn't find articles for your search. Please try something different.</h4>
                            <img src="{{asset('assets/images/fortnite/llama-wall.png')}}" style="width: 250px;" alt="Nothing found">
                        </div>
                    @endif
                    <div id="all-skins">
                        <div style="text-align: center; font-size: 18px;"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
                    {{--@foreach($skins as $skin)
                            @component('shop.components.skin-grid-item')
                                @slot('skin', $skin)
                            @endcomponent
                        @endforeach--}}
                    </div>
                </div>

                {{-- Pagination --}}
                @if($skins->hasMorePages())
                    <div class="pagination-wrapper">
                        {{ $skins->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@section('pageSpecificJS')
<script src="{{URL::to('/')}}/js/vendor/modernizr-3.7.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="{{URL::to('/')}}/js/vendor/ion.rangeSlider.min.js"></script>
<script>window.jQuery || document.write('<script src="{{URL::to('/')}}/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
<script src="{{URL::to('/')}}/js/plugins.js"></script>
<script src="{{URL::to('/')}}/assets/js/skins-filter.js"></script>
@endsection
