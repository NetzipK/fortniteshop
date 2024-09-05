<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xs-6 article-grid-item" style="max-width:235px;">
  <article class="product-item">
    <div class="row">
        <div class="col-sm-3" style="display: flex; justify-content: center; min-height: 15rem; align-items: center;">
            <div class="product-overlay">
                {{-- <div class="product-mask"></div> --}}
                <a href="{{route('article.show', $article->external_id)}}" class="product-permalink"></a>
                <img style="padding: 0.25rem; height: 150px; object-fit: contain;" src="{{route('article.image', $article->image_name)}}" class="img-responsive" alt="Fortnitemall.gg Item {{ $article->name }}">
                {{-- <img src="assets/images/products/product-1b.jpg" class="img-responsive product-image-2" alt=""> --}}
                {{-- <div class="product-quickview">
                    <a class="btn btn-quickview" data-toggle="modal" data-target="#product-quickview">Quick View</a>
                </div> --}}
              </div>
          </div>
          <div class="col-sm-9">
            <div class="product-body">
                <hr style="margin-top: 0px;">
                <div style="font-size: 1.25rem; font-weight: 700;  min-height: 5.5rem;">
                    <span style="font-size: 1.35rem; color: #337ab7;">
                        <span id="article-stepsize-{{$article->external_id}}" data-stepsize="{{ $article->amount_step_size }}">
                            {{ $article->amount_step_size }}
                        </span>x
                    </span>
                    {{ str_limit($article->name, 40, "...") }}
                </div>

                <div class="product-labels">
                    @if($article->is_featured)
                        <span class="label label-success">Featured</span>
                    @endif
                    @if($article->is_sale)
                        <span class="label label-danger">sale</span>
                    @endif
                </div>
                  <span class="price" style="font-size: 1.2rem;">
                    {{-- <del><span class="amount">
                            USD <span id="oldPrice-{{$article->external_id}}">
                            {{ number_format($article->price + 1, 2)}}
                            </span>
                        </span>
                    </del> --}}
                    <ins>
                        <span class="amount text-danger" style="font-size: 2rem;">
                            {{ \App\Currency::getCurrencyCode() }} <span id="newPrice-{{$article->external_id}}">{{ \App\Currency::getCurrencyAmount($article->price) }}</span>
                        </span>
                    </ins>
                  </span>

                  <hr style="margin-top: 10px; margin-bottom: 10px;">
                  <div style="font-size: 2rem; display: flex; justify-content: center; align-content: center;">
                    <form style="display: flex; align-items: center; width: 100%; justify-content: space-evenly;" id="add-to-cart-{{$article->external_id}}" action="{{ route('cart.add', $article->external_id) }}" method="POST">
                        {{ csrf_field() }}
                        <div style="font-size: 1.25rem; background-color: #f7ca4e;" id="article-decrease-{{$article->external_id}}" data-id="{{$article->external_id}}" class="btn btn-warning article-size-input decrease-article">
                            <i class="fa fa-minus"></i>
                        </div>
                        <input
                            class="article-input"
                            id="article-price-{{$article->external_id}}"
                            data-old="{{ number_format($article->price + 1, 2) }}"
                            data-current="{{ number_format($article->price, 2) }}"
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
                  <hr style="margin-bottom: 0px; margin-top: 10px;">
                  <div class="buttons">
                    <a href="{{route('article.show', $article->external_id)}}" class="btn btn-secondary btn-sm btn-block">
                        <i class="fa fa-info"></i>
                        More information
                    </a>
                    <a href="{{route('cart.add', $article->external_id)}}" class="btn btn-primary btn-sm btn-block add-to-cart" onclick="event.preventDefault(); document.getElementById('add-to-cart-{{$article->external_id}}').submit();">
                        <i class="fa fa-shopping-cart"></i> Add to cart
                    </a>
                  </div>
              </div>
          </div>
      </div>
  </article>
</div>
