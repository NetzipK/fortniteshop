@extends('layouts.shop')

@section('siteTitle')
{{$skin->name}}
@endsection
@section('seo')
<meta name="description" content="Buy {{$skin->name}} from fortnitemall.gg">
<meta name="og:title" property="og:title" content="Buy {{$skin->name}} from fortnitemall.gg">
<link href="{{Request::url()}}" rel="canonical">
@endsection

@section('content')
<section class="lazy content jumbotron jumbotron-video-5" data-bg="url({{asset('/assets/images/jumbotron/header_15.jpg')}})" style="margin-top: 50px;">
</section>

<section class="content products">
  <div class="container">
    <h2 style="margin-bottom: 2rem;" class="component-heading text-center">
      Get to know the fortnite item  <span class="color">{{$skin->name}}</span>
    </h2>


    <article class="product-item product-single">
          <div class="row" style="display: flex; align-items: center; padding: 2rem;">
              <div class="col-xs-4">
                <img style="width: 100%; padding: 2rem;" src="{{asset('/assets/images/skins/' . $skin->image_name)}}" alt="Fortnitemall.gg {{$skin->name}} item">
              </div>
              <div class="col-xs-8">
                <div class="product-body">
                <span class="price">
                    {{-- <del><span class="amount">
                            USD <span id="oldPrice-{{$skin->external_id}}">
                            {{ number_format($skin->price + 1, 2)}}
                            </span>
                        </span>
                    </del> --}}
                    <ins>
                        <span class="amount text-danger" style="font-size: 2rem;">
                            USD <span id="newPrice-{{$skin->external_id}}">{{ number_format($skin->price, 2) }}</span>
                        </span>
                    </ins>
                  </span>
                  <h3><span style="font-size: 1.35rem; color: #337ab7;">
                      <span id="skin-stepsize-{{$skin->external_id}}" data-stepsize="{{ $skin->amount_step_size }}">
                          {{ $skin->amount_step_size }}
                      </span>x
                  </span>{{$skin->name}}</h3>
                  <p style="color: #b5bbcf;">
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
                      <p>{!!$skin->description!!}</p>
                      <div class="product-form clearfix">
                          <div class="row row-no-padding">

                              <div class="col-md-3 col-sm-4">
                                  <div class="product-quantity clearfix">
                                    <form style="display: flex; align-items: center; width: 100%; justify-content: space-evenly;" id="add-to-cart-{{$skin->external_id}}" action="{{ route('cart.add', $skin->external_id) }}" method="POST">
                                      {{ csrf_field() }}
                                      <div style="font-size: 1.25rem; background-color: #f7ca4e;" id="skin-decrease-{{$skin->external_id}}" data-id="{{$skin->external_id}}" class="btn btn-warning article-size-input decrease-article">
                                          <i class="fa fa-minus"></i>
                                      </div>
                                      <input
                                          class="article-input"
                                          id="skin-price-{{$skin->external_id}}"
                                          data-old="{{ $skin->price + 1 }}"
                                          data-current="{{ $skin->price }}"
                                          data-id="{{$skin->external_id}}"
                                          name="quantity"
                                          style="max-width: 7rem; text-align: center;"
                                          type="text"
                                          value="1">
                                      <div style="font-size: 1.25rem; background-color: #f7ca4e;" id="skin-increase-{{$skin->external_id}}" data-id="{{$skin->external_id}}"  class="btn btn-warning article-size-input increase-article">
                                          <i class="fa fa-plus"></i>
                                      </div>
                                  </form>
                                  </div>
                              </div>

                              <div class="col-md-3 col-sm-12">
                                <a href="{{route('cart.add', $skin->external_id)}}"  class="btn btn-danger add-to-cart" onclick="event.preventDefault(); document.getElementById('add-to-cart-{{$skin->external_id}}').submit();"><i class="fa fa-shopping-cart"></i>Add to cart</a>
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
      <h2 style="margin-bottom: 2rem;" class="component-heading text-center">Other Fortnite skins <span class="color"> you may like</span></h2>
      <hr>
    </div>
    <div class="row grid" id="products" style="display: flex; justify-content: center; flex-wrap:wrap;">
        @foreach($skins as $skin)
          @component('shop.components.skin-grid-item')
            @slot('skin', $skin)
          @endcomponent
        @endforeach
    </div>
</section>

<section class="content jumbotron jumbotron-video-3" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_17.jpg)">
</section>

@endsection

@section('pageSpecificJS')
@endsection
