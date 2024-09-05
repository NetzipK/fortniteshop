@extends('layouts.shop')

@section('siteTitle')
{{$article->name}}
@endsection
@section('seo')
<meta name="og:title" property="og:title" content="Buy {{$article->name}} from fortnitemall.gg">
<link href="{{Request::url()}}" rel="canonical">

<meta name="description" content="Buy {{$article->name}} from fortnitemall.gg. Quick delivery, 24/7 online delivery and support. 100% trusted services.">
<meta property="og:title" content="Buy {{$article->name}} from fortnitemall.gg">
<link href="{{Request::url()}}" rel="canonical">
<meta property="og:type" content="website" />
<meta property="og:description" content="Buy {{$article->name}} from fortnitemall.gg. Quick delivery, 24/7 online delivery and support. 100% trusted services." />
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:site_name" content="FortniteMall.gg" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="Buy {{$article->name}} from fortnitemall.gg. Quick delivery, 24/7 online delivery and support. 100% trusted services." />
<meta name="twitter:title" content="Buy {{$article->name}} from fortnitemall.gg" />

<meta property="og:image" content="{{route('article.image', $article->image_name)}}">
@endsection

@section('content')
<section class="lazy content jumbotron jumbotron-video-5" data-bg="url({{asset('/assets/images/jumbotron/header_15.jpg')}})" style="margin-top: 50px;">
</section>

<section class="content products">
  <div class="container">
    <h2 style="margin-bottom: 2rem;" class="component-heading text-center">
      Get to know the fortnite item  <span class="color">{{$article->name}}</span>
    </h2>


    <article class="product-item product-single">
          <div class="row" style="display: flex; align-items: center; padding: 2rem;">
              <div class="col-xs-4">
                <img style="width: 100%; padding: 2rem;" src="{{route('article.image', $article->image_name)}}" alt="Fortnitemall.gg {{$article->name}} item">
              </div>
              <div class="col-xs-8">
                <div class="product-body">
                <span class="price">
                    {{-- <del><span class="amount">
                            USD <span id="oldPrice-{{$article->external_id}}">
                            {{ number_format($article->price + 1, 2)}}
                            </span>
                        </span>
                    </del> --}}
                    <ins>
                        <span class="amount text-danger" style="font-size: 2rem;">
                            USD <span id="newPrice-{{$article->external_id}}">{{ number_format($article->price, 2) }}</span>
                        </span>
                    </ins>
                  </span>
                  <h3><span style="font-size: 1.35rem; color: #337ab7;">
                      <span id="article-stepsize-{{$article->external_id}}" data-stepsize="{{ $article->amount_step_size }}">
                          {{ $article->amount_step_size }}
                      </span>x
                  </span>{{$article->name}}</h3>
                  <p style="color: #b5bbcf;">
                    @if($article->category->count() > 0)
                    Available in category:
                    @endif
                    @foreach($article->category as $category)
                        <a href="{{route('shop.category', $category->id)}}">
                            <span class="label label-info">{{$category->display_name}}</span>
                        </a>
                    @endforeach
                    </p>
                      {{-- <div class="product-labels">
                          <span class="label label-info">new</span>
                          <span class="label label-danger">sale</span>
                      </div> --}}
                      {{-- <div class="product-rating">
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star-o"></i>
                          <i class="fa fa-star-o"></i>
                      </div>
                      <span class="price">
                          <del><span class="amount">$36.00</span></del>
                          <ins><span class="amount">$30.00</span></ins>
                      </span>
                      <ul class="list-unstyled product-info">
                          <li><span>ID</span>U-187423</li>
                          <li><span>Availability</span>In Stock</li>
                          <li><span>Brand</span>Esprit</li>
                          <li><span>Tags</span>Dress, Black, Women</li>
                      </ul> --}}
                      <p>{!!$article->description!!}</p>
                      <div class="product-form clearfix">
                          <div class="row row-no-padding">

                              <div class="col-md-3 col-sm-4">
                                  <div class="product-quantity clearfix">
                                    <form style="display: flex; align-items: center; width: 100%; justify-content: space-evenly;" id="add-to-cart-{{$article->external_id}}" action="{{ route('cart.add', $article->external_id) }}" method="POST">
                                      {{ csrf_field() }}
                                      <div style="font-size: 1.25rem; background-color: #f7ca4e;" id="article-decrease-{{$article->external_id}}" data-id="{{$article->external_id}}" class="btn btn-warning article-size-input decrease-article">
                                          <i class="fa fa-minus"></i>
                                      </div>
                                      <input
                                          class="article-input"
                                          id="article-price-{{$article->external_id}}"
                                          data-old="{{ $article->price + 1 }}"
                                          data-current="{{ $article->price }}"
                                          data-id="{{$article->external_id}}"
                                          name="quantity"
                                          style="max-width: 7rem; text-align: center;"
                                          type="text"
                                          value="1">
                                      <div style="font-size: 1.25rem; background-color: #f7ca4e;" id="article-increase-{{$article->external_id}}" data-id="{{$article->external_id}}"  class="btn btn-warning article-size-input increase-article">
                                          <i class="fa fa-plus"></i>
                                      </div>
                                  </form>
                                  </div>
                              </div>

                              <div class="col-md-3 col-sm-12">
                                <a href="{{route('cart.add', $article->external_id)}}"  class="btn btn-danger add-to-cart" onclick="event.preventDefault(); document.getElementById('add-to-cart-{{$article->external_id}}').submit();"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                              </div>

                          </div>
                      </div>

                  </div>
              </div>
          </div>
      </article>

      <div class="row text-center">
        <a class="btn btn-info" href="{{ url()->previous() }}">Back to shop</a>
      </div>
  </div>
</section>

<section class="content" style="background: white;">
  <div class="container">
      <h2 style="margin-bottom: 2rem;" class="component-heading text-center">Other Fortnite items <span class="color"> you may like</span></h2>
      <hr>
    </div>
    @include('shop.partials.featuredProductsRow')
</section>

<section class="content jumbotron jumbotron-video-3" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_17.jpg)">
</section>

@endsection

@section('pageSpecificJS')
@endsection
