@extends('layouts.shop')

@section('siteTitle')
Fortnite Item Shop
@endsection
@section('seo')
<meta name="description" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<meta name="og:title" property="og:title" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<link href="{{Request::url()}}" rel="canonical">
@endsection

@section('content')
<section class="content jumbotron jumbotron-video-2" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_35.png); border-bottom: 3px solid #19A5D4;">
</section>

<section class="content products">
  <div class="container">
    <h2 class="component-heading text-center">What time is it? <span class="color">Shopping time!</span></h2>
        <div class="row" style="margin-bottom: 3rem;">
            <p class="text-center text-muted">
                We have everything you can think of! Choose your article. Select the amount. Buy it. Done.
            </p>
        </div>

  <div class="row" >
      <div class="col-sm-12 text-center">
        @if (Session::has('article-added'))
            <div class="alert alert-info" role="alert">
            <strong>Oh yes!</strong>
            <br>
            The article was successfully added to your shopping cart.
            <br>
            You can view it <a href="{{route('cart.index')}}"><strong>here</strong></a>
            </div>
         @endif
      </div>
      <div class="col-sm-3">
        @include('shop.partials.article-sidebar')
      </div>
      <div class="col-sm-9">
          {{-- Articlegrid --}}
          <div class="row grid" id="products">
            @if($articles->count() === 0)
            <div class="text-center">
              <h3 style="font-family: 'Luckiest Guy'; letter-spacing: 1px; font-size: 2.5rem;"> NOT THE LLAMA YOU'RE LOOKING FOR</h3>
              <h4>We couldn't find articles for your search. Please try something different.</h4>
              <img src="{{asset('assets/images/fortnite/llama-wall.png')}}" style="width: 250px;" alt="Nothing found">
            </div>
            @endif
            @foreach($articles as $article)
              @component('shop.components.article-grid-item')
                @slot('article', $article)
              @endcomponent
            @endforeach
          </div>

          {{-- Pagination
          @if($articles->hasMorePages()) --}}
          <div class="pagination-wrapper">
                {{ $articles->links() }}
            </div>
         {{-- @endif --}}
      </div>
  </div>
</div>

</section>
@endsection

@section('pageSpecificJS')
@endsection
