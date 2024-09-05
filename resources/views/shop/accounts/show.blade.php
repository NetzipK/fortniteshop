@extends('layouts.shop')

@section('siteTitle')
{{$account->name}}
@endsection
@section('seo')
<meta name="description" content="Buy {{$account->name}} from fortnitemall.gg">
<meta name="og:title" property="og:title" content="Buy {{$account->name}} from fortnitemall.gg">
<link href="{{Request::url()}}" rel="canonical">
@endsection

@section('pageSpecificCSS')
<link href="{{URL::to('/')}}/assets/css/showstyle.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<section class="content jumbotron jumbotron-video-7" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_25.png); margin-top: 50px; border-bottom: 4px solid #19A5D4;"></section>
</section>

<section class="content products">
  <div class="custom-container">
      @if (Session::has('article-added'))
          <div class="alert alert-info" style="text-align: center;" role="alert">
              <strong>Oh yes!</strong>
              <br>
              The account was successfully added to your shopping cart.
              <br>
              You can view it <a href="{{route('cart.index')}}"><strong>here</strong></a>
          </div>
      @endif
      <div class="row sidebar">
          <div class="col-sm-4 col-md-3 col-lg-3 hidden-xs hidden-sm">
            <div class="widget widget-checkbox">
                <div class="widget-body border-bottom" style="height: 400px;">
                    <div class="account-image">
                        @if($account->full_access == true)
                        <img style="height: 255px" src="{{asset('/assets/images/accounts/br/01_full_access.png')}}" class="img-responsive" alt="Fortnitemall.gg Item {{ $account->name }}">
                        @elseif($account->full_access == false)
                        <img style="height: 255px;" src="{{asset('/assets/images/accounts/br/02_half_access.png')}}" class="img-responsive" alt="Fortnitemall.gg Item {{ $account->name }}">
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="widget widget-checkbox">
                <div class="widget-body border-bottom" style="height: 400px;">
                    <div class="container-fluid account-details-container">
                        <div class="row account-title">
                            {{ $account->name }}
                        </div>
                        <div class="row account-price">
                            <label>Price:</label> <span>{{ number_format($account->price, 2) }} USD</span>
                        </div>
                        <hr>
                        <div class="row all-details">
                            <div class="col-xs-10 col-sm-4 col-lg-3 detail-name">
                                <label>Full E-Mail access:</label>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-lg-1">
                                yes
                            </div>
                        </div>
                        <div class="row all-details">
                            <div class="col-xs-10 col-sm-4 col-lg-3 detail-name">
                                <label>Current Account Level:</label>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-lg-1">
                                130
                            </div>
                        </div>
                        <div class="row all-details">
                            <div class="col-xs-10 col-sm-4 col-lg-3 detail-name">
                                <label>V-Bucks amount:</label>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-lg-1">
                                1.300
                            </div>
                        </div>
                        <div class="row all-details">
                            <div class="col-xs-10 col-sm-4 col-lg-3 detail-name">
                                <label>Has current Batlle Pass:</label>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-lg-1">
                                no
                            </div>
                        </div>
                        <div class="row all-details">
                            <div class="col-xs-10 col-sm-4 col-lg-3 detail-name">
                                <label>Current Battle Pass Level:</label>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-lg-1">
                                23
                            </div>
                        </div>
                        <div class="row all-details">
                            <div class="col-xs-10 col-sm-4 col-lg-3 detail-name">
                                <label>Has Save The World:</label>
                            </div>
                            <div class="col-xs-2 col-sm-2 col-lg-1">
                                yes
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                <form id="add-to-cart-{{$account->external_id}}" action="{{route('cart.add', $account->external_id)}}" method="post">
                                    {{ csrf_field() }}
                                    <a href="{{route('cart.add', $account->external_id)}}" class="btn btn-danger btn-sm btn-block add-to-cart"  onclick="event.preventDefault(); document.getElementById('add-to-cart-{{$account->external_id}}').submit();">
                                        <i class="fa fa-shopping-cart"></i> Add to cart
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row sidebar">
        <div class="col-sm-12">
            <div class="widget widget-checkbox">
                <div class="widget-body" style="min-height: 790px;">
                    <div class="details-wrapper">
                        <div class="scrollbar test-border">
                            <div class="scrollbar-items">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis feugiat euismod eros, eget viverra turpis commodo eu. Proin semper est massa, a interdum tellus blandit in. Proin ultricies, felis at ultrices cursus, velit metus venenatis odio, quis volutpat felis mauris ac nisl. Praesent nibh lacus, pharetra rhoncus sollicitudin at, vehicula et nulla. Vestibulum ex tellus, ultrices sed sagittis sit amet, ultrices nec enim. Vestibulum accumsan, est ac tincidunt ultrices, velit velit tristique turpis, ac dignissim libero mi sed risus. Proin porttitor vulputate nunc at luctus. Phasellus ac dui quis ante varius pulvinar. Vivamus ut massa non nisi finibus maximus. Nunc volutpat diam pharetra erat lobortis, a vestibulum tellus aliquet. Etiam congue mollis ex, at laoreet arcu malesuada id. Phasellus molestie dictum lacinia. Fusce tincidunt sagittis sapien.

                                Donec laoreet mauris id est euismod, a bibendum sem vulputate. Ut pharetra ligula sed tortor tincidunt dignissim. Phasellus iaculis libero lectus. Suspendisse pellentesque dolor eros, ut egestas magna facilisis vel. Pellentesque vulputate eros et scelerisque elementum. In et leo pharetra, dapibus mi et, dapibus magna. In gravida arcu est, iaculis sagittis libero suscipit eu. Suspendisse ultrices lorem vel est interdum consequat. Nam volutpat semper mauris, nec convallis diam egestas et. Vivamus mattis, felis sit amet porta rutrum, purus turpis euismod lorem, ac tristique massa orci eu purus. Vestibulum pretium, ante lacinia pulvinar pellentesque, erat augue vehicula magna, a finibus nibh urna ut massa. Duis efficitur metus eget metus varius, a sodales enim eleifend. Vivamus convallis nunc aliquam ultricies sodales. Donec commodo ligula ligula, ac gravida purus dignissim eget.

                                Quisque eu elit erat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec id porttitor ligula. Proin accumsan at nisl vel interdum. Pellentesque at libero nulla.

                                Ut vel sapien ac ante imperdiet sagittis sit amet sagittis eros. Morbi placerat est velit, sit amet pretium lectus tristique vulputate. Vivamus elementum, felis vitae pulvinar laoreet, sapien diam suscipit nisi, eu auctor eros mi at massa. Maecenas tortor dolor, laoreet id justo sed, rutrum aliquam arcu. Praesent lacinia nulla elit, in finibus enim tempus eget. Maecenas et lacus suscipit, sagittis lacus vitae, facilisis urna. Suspendisse iaculis metus sed purus mollis placerat. Sed in magna sem. Suspendisse potenti. Proin et vulputate tortor.

                                Fusce feugiat vel mi at finibus. Phasellus eu purus ipsum. Maecenas est lectus, luctus vel euismod et, egestas eu ante. Quisque semper mauris ex, faucibus suscipit sapien rutrum egestas. Aliquam mattis dapibus dui eget lobortis. Mauris euismod, felis quis ultricies porttitor, metus turpis ornare lectus, sit amet condimentum enim orci vitae quam. Pellentesque a iaculis dui. Donec porttitor enim in sollicitudin ullamcorper.

                                Phasellus blandit volutpat erat id sagittis. Vestibulum eu enim eget nibh dignissim interdum ut ut ante. Nulla metus leo, pellentesque laoreet egestas ut, porttitor a ipsum. In nec viverra dui. Mauris et orci at eros suscipit dignissim. Donec sollicitudin nisl sit amet libero aliquet, vel fringilla mauris fermentum. Cras ultrices, est et egestas consequat, nunc magna consequat nibh, ac varius tortor ante nec nisl. Donec vestibulum nulla eu ex tincidunt, tristique feugiat est mollis. Aenean sit amet gravida nisl. Sed vitae pretium tellus. Nunc pellentesque diam sit amet mollis fringilla. Sed iaculis arcu vitae est maximus, vitae lobortis leo pharetra. Nulla finibus eu est eget maximus. Duis fermentum ex aliquet suscipit egestas. Curabitur posuere sed orci eget tincidunt.

                                Proin tincidunt pellentesque metus, non volutpat diam ornare sit amet. Donec euismod nulla imperdiet sollicitudin sollicitudin. Aliquam purus risus, varius iaculis suscipit at, gravida pretium turpis. In hac habitasse platea dictumst. Nullam malesuada mauris libero. Vestibulum vehicula et dolor eget bibendum. Sed magna tortor, ullamcorper sed sodales vitae, condimentum at sem. Maecenas pharetra fermentum mattis. Cras ac metus in ipsum luctus volutpat sed quis erat. Curabitur lectus sem, congue eget auctor ac, tempor a augue. Nam at metus pulvinar, venenatis nulla non, varius turpis. Etiam in nunc quis leo condimentum dapibus sed at felis. Pellentesque hendrerit vestibulum ipsum eget luctus. Nulla vitae sapien nibh. Proin et facilisis tellus, euismod fermentum mauris.

                                Maecenas vehicula, purus ut mattis suscipit, diam velit auctor nisl, a lacinia sem libero at nulla. Etiam id erat iaculis, malesuada lacus at, eleifend ipsum. In vel ullamcorper urna. Sed sed augue ut arcu semper porttitor. Maecenas tincidunt rutrum neque, ultricies fermentum leo malesuada ut. Phasellus id lacinia dui. Nam sit amet mi ac augue mattis mollis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent egestas tempus purus, in faucibus tellus tempor quis. Sed pretium, leo non tempus lobortis, nunc libero condimentum mi, id gravida tellus quam ac turpis. Proin vitae ornare turpis. Quisque tortor enim, auctor eu volutpat at, dapibus id mi. Ut pellentesque dolor eget ligula egestas efficitur. Nullam egestas magna sit amet mauris fermentum, vel porta neque convallis. Fusce feugiat, tellus a egestas iaculis, urna urna pellentesque arcu, in consequat lacus lorem non enim. Donec neque lacus, accumsan in interdum sit amet, suscipit ac sapien.

                                Ut sagittis ultricies nulla eu porta. Quisque sit amet dui felis. In nibh lectus, porta a pellentesque et, tempor vitae tortor. Pellentesque semper ex et ligula pulvinar, vel iaculis dolor ornare. Nulla fringilla quam a quam luctus convallis. Quisque dignissim, nulla vitae luctus maximus, dolor nibh suscipit augue, eget luctus tellus lectus bibendum nisl. Aliquam tempor varius velit, quis ultricies risus elementum ut. Donec tempor aliquet auctor. Suspendisse id mauris tincidunt nisi egestas consectetur et ut ipsum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum quis tellus ut enim interdum elementum. In faucibus posuere ligula rutrum varius. Pellentesque lectus mi, varius non ligula non, cursus vestibulum diam. Suspendisse urna nulla, sollicitudin vel hendrerit vitae, pharetra et orci. Fusce nec magna lobortis, dictum erat sit amet, consectetur purus. Morbi erat dui, mattis vel nisl sit amet, imperdiet convallis tortor.

                                Nam sagittis risus sit amet ornare vulputate. Quisque urna sem, efficitur eu dolor nec, vulputate tincidunt augue. Sed non urna interdum, elementum diam et, consectetur augue. Nam aliquam, augue id imperdiet porta, nunc sapien pellentesque massa, eget convallis orci turpis id ligula. Proin ipsum dui, malesuada non molestie in, faucibus at lacus. Mauris pulvinar imperdiet ante. Nam consectetur neque et ante tincidunt accumsan. Nullam eu erat quis enim volutpat ultrices ac vel nisi. Sed odio magna, feugiat et urna eu, mattis viverra sem. Curabitur gravida lobortis lorem, ut feugiat massa cursus in. Mauris tempus nisl sed massa iaculis imperdiet. Cras nec cursus felis. Curabitur ultricies augue nec bibendum ultricies. Aenean quis dignissim ex, in dictum orci.

                                Vivamus ut hendrerit nunc. Donec eu dui non leo posuere laoreet. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus accumsan volutpat ante, auctor consectetur quam viverra non. Integer ut congue quam. Praesent a varius dui. Sed fermentum velit non dolor viverra iaculis. Maecenas tempor elementum mauris a ultrices.

                                Nullam quis bibendum leo. Aliquam maximus, nisl at ullamcorper hendrerit, leo diam dignissim dui, sed molestie erat diam ut nibh. Donec eu rutrum augue. Mauris et tristique ipsum, et finibus orci. Vivamus laoreet tellus sed malesuada auctor. Aliquam eu arcu diam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam et pellentesque ipsum. Curabitur pellentesque ac ex sed suscipit.

                                Morbi varius sed nulla at eleifend. Etiam a mi tristique, pharetra tortor ac, consequat magna. In lobortis iaculis augue, non ultrices dolor. Quisque ac feugiat nulla, dignissim interdum nibh. Phasellus sit amet efficitur diam. Maecenas tellus enim, tempus sed tincidunt vitae, tristique dignissim arcu. Donec arcu tortor, varius et ullamcorper sed, mollis ut nibh. Nam vel gravida magna. In hac habitasse platea dictumst. Suspendisse in ex iaculis, consequat ipsum vel, porta libero.

                                Pellentesque sed arcu at tellus malesuada placerat eu nec dolor. In ultrices facilisis egestas. Nullam quis bibendum dui, id accumsan magna. Donec rhoncus posuere velit a venenatis. Etiam at odio rhoncus, efficitur ipsum a, lacinia diam. Ut at condimentum justo, vitae condimentum sem. Pellentesque purus dolor, ornare eu gravida ac, molestie gravida nisl. Aenean risus sem, rutrum vel odio at, sodales blandit nulla. Curabitur malesuada fermentum tellus, eu feugiat odio tempor ut. Curabitur placerat ac tellus quis cursus. Suspendisse molestie mi lacus, ut scelerisque eros maximus vitae. Aliquam porttitor tincidunt enim, vel malesuada justo eleifend a. Phasellus et lorem quis eros tempus fringilla.

                                Cras vel maximus urna. Sed vehicula lorem eget aliquam ultrices. Integer eget imperdiet orci, at euismod elit. Morbi ut quam et lacus pulvinar lobortis et sed nisi. Praesent luctus, sem in vestibulum maximus, tortor orci faucibus massa, non ornare lorem massa non lorem. Quisque ut metus nec metus laoreet auctor. Nulla facilisi. Sed nisi lorem, accumsan in diam a, suscipit pretium nibh. Donec fringilla aliquam leo, a laoreet est pretium at. Vivamus rutrum sagittis sapien, sit amet luctus ipsum tempor at.

                                Nulla mauris dolor, tincidunt at ante non, semper vehicula tortor. Sed bibendum ultricies pulvinar. Maecenas vel ultrices ex, a maximus eros. Morbi fermentum mollis tempor. Nulla hendrerit sed nunc eu condimentum. Suspendisse eu pharetra enim. Suspendisse non accumsan sem. Curabitur nec tristique diam. Pellentesque mollis erat nec facilisis vulputate. Donec ultricies lacus vitae elit bibendum, sed pellentesque risus bibendum. Phasellus eros ligula, cursus sed rutrum at, faucibus non neque.

                                Cras ut ultricies justo. Nunc elementum pharetra nisi, eu ultricies magna auctor sed. In vel porta nisi. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam turpis lectus, placerat eu vehicula eu, ornare nec turpis. Donec placerat, ipsum eu tempor scelerisque, elit odio hendrerit nibh, nec vestibulum sapien felis et enim. Vivamus finibus, magna in sodales lacinia, metus mauris pretium tortor, et sodales augue leo sit amet neque.

                                Vestibulum vehicula ut ipsum vitae lobortis. Praesent mauris enim, aliquet vitae gravida id, fringilla et ex. Morbi a nibh dignissim ex accumsan consectetur. Vestibulum sit amet sodales enim, porta mattis ligula. Pellentesque ultrices, enim eget porttitor volutpat, orci nulla volutpat neque, et commodo lacus felis ac leo. Phasellus dapibus lacinia nunc, sed scelerisque ligula pharetra in. Donec tempor lectus vel lorem vulputate, non semper ante consectetur. Nam est elit, venenatis quis nulla quis, ultrices maximus libero. In lobortis ut enim non aliquam. Proin volutpat consequat metus. Proin vestibulum ipsum orci, non lobortis nisi laoreet eget. Curabitur ornare convallis nisl id vulputate.

                                Vivamus lobortis lacus a sapien ornare, vel tempor nunc tempor. Integer vel sem dolor. Donec maximus viverra quam, a suscipit diam pharetra nec. Suspendisse vulputate commodo nulla, a venenatis metus laoreet non. Donec facilisis risus porttitor vehicula iaculis. Suspendisse potenti. Nulla est orci, scelerisque nec ultricies et, commodo a purus. In rhoncus molestie dolor, id facilisis metus cursus quis.

                                Integer blandit, ante in porta fermentum, dolor nunc vehicula neque, non maximus ante nisi ut metus. In hac habitasse platea dictumst. Cras pharetra auctor leo id finibus. Proin id imperdiet mi, quis rutrum lectus. Quisque eget ipsum ut tortor ornare tristique. Morbi faucibus mi in urna euismod condimentum eget ut risus. Vivamus eu pretium ex. Integer et odio nibh. Aenean id congue nisl, et venenatis ligula.

                                Nullam vehicula, leo sed volutpat ultricies, mi urna sagittis massa, eu feugiat tellus magna et tortor. Vestibulum varius neque eu bibendum tempus. Phasellus sodales metus at pulvinar auctor. Integer magna tortor, hendrerit faucibus purus eu, lacinia vehicula erat. Fusce bibendum ante ut fermentum dapibus. Donec vel semper justo, eu fermentum ante. Fusce rhoncus purus a sollicitudin rhoncus. Praesent dictum pretium sapien non tincidunt. In hac habitasse platea dictumst.

                                Nam ante tellus, tincidunt in est in, mattis bibendum orci. Integer efficitur sapien nunc. Donec sed pretium justo, et placerat velit. Suspendisse semper mi et enim venenatis, in bibendum est rhoncus. Aliquam quis enim felis. Etiam euismod porttitor lectus eu sagittis. Vestibulum tempus felis gravida augue fringilla gravida. Nulla vestibulum, libero a suscipit tristique, eros leo tincidunt mi, ac mollis nisi eros eget metus. Proin nec semper nunc.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<article class="product-item product-single">
          <div class="row" style="display: flex; align-items: center; padding: 2rem;">
              <div class="col-xs-4">
                <img style="width: 100%; padding: 2rem;" src="{{asset('/assets/images/accounts/' . $account->image_name)}}" alt="Fortnitemall.gg {{$account->name}} item">
              </div>
              <div class="col-xs-8">
                <div class="product-body">
                <span class="price">
                    {{-- <del><span class="amount">
                            USD <span id="oldPrice-{{$account->external_id}}">
                            {{ number_format($account->price + 1, 2)}}
                            </span>
                        </span>
                    </del>
                    <ins>
                        <span class="amount text-danger" style="font-size: 2rem;">
                            USD <span id="newPrice-{{$account->external_id}}">{{ number_format($account->price, 2) }}</span>
                        </span>
                    </ins>
                  </span>
                  <h3><span style="font-size: 1.35rem; color: #337ab7;">
                      <span id="account-stepsize-{{$account->external_id}}" data-stepsize="{{ $account->amount_step_size }}">
                          {{ $account->amount_step_size }}
                      </span>x
                  </span>{{$account->name}}</h3>
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
                      </ul>
                      <p>{!!$account->description!!}</p>
                      <div class="product-form clearfix">
                          <div class="row row-no-padding">

                              <div class="col-md-3 col-sm-4">
                                  <div class="product-quantity clearfix">
                                    <form style="display: flex; align-items: center; width: 100%; justify-content: space-evenly;" id="add-to-cart-{{$account->external_id}}" action="{{ route('cart.add', $account->external_id) }}" method="POST">
                                      {{ csrf_field() }}
                                      <div style="font-size: 1.25rem; background-color: #f7ca4e;" id="account-decrease-{{$account->external_id}}" data-id="{{$account->external_id}}" class="btn btn-warning article-size-input decrease-article">
                                          <i class="fa fa-minus"></i>
                                      </div>
                                      <input
                                          class="article-input"
                                          id="account-price-{{$account->external_id}}"
                                          data-old="{{ $account->price + 1 }}"
                                          data-current="{{ $account->price }}"
                                          data-id="{{$account->external_id}}"
                                          name="quantity"
                                          style="max-width: 7rem; text-align: center;"
                                          type="text"
                                          value="1">
                                      <div style="font-size: 1.25rem; background-color: #f7ca4e;" id="account-increase-{{$account->external_id}}" data-id="{{$account->external_id}}"  class="btn btn-warning article-size-input increase-article">
                                          <i class="fa fa-plus"></i>
                                      </div>
                                  </form>
                                  </div>
                              </div>

                              <div class="col-md-3 col-sm-12">
                                <a href="{{route('cart.add', $account->external_id)}}"  class="btn btn-danger add-to-cart" onclick="event.preventDefault(); document.getElementById('add-to-cart-{{$account->external_id}}').submit();"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                              </div>

                          </div>
                      </div>

                  </div>
              </div>
          </div>
      </article>--}}

      <div class="row text-center">
        <a class="btn btn-info" href="{{ route('accounts.index') }}">Back to accounts</a>
      </div>
  </div>
</section>

<section class="content" style="background: white;">
  <div class="container">
      <h2 style="margin-bottom: 2rem;" class="component-heading text-center">Other Fortnite accounts <span class="color"> you may like</span></h2>
      <hr>
    </div>
    <div class="row grid" id="products" style="display: flex; justify-content: center; flex-wrap:wrap;">
        @foreach($accounts as $account)
          @component('shop.components.account-grid-item')
            @slot('account', $account)
          @endcomponent
        @endforeach
    </div>
</section>

<section class="content jumbotron jumbotron-video-3" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_17.jpg)">
</section>

@endsection

@section('pageSpecificJS')
@endsection
