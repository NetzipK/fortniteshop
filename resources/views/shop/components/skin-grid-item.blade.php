<div class="col-sm-4 col-md-2 col-xl-3 col-lg-5 col-xs-5 article-grid-item" style="max-width:218px;">
  <article class="product-item">
    <div class="row">
        <div class="col-sm-3" style="display: flex; justify-content: center; min-height: 15rem; align-items: center;">
            <div class="product-overlay">
                <a href="{{route('skin.show', $skin->external_id)}}" class="product-permalink"></a>
                <div style="position: relative;">
                    @if($skin->available_on_PC == true)
                        <img style="width: 100%;" src="{{route('skin.image', 'pc.png')}}" class="img-responsive" alt="Fortnitemall.gg Skin {{ $skin->name }}">
                    @endif
                    @if($skin->available_on_PS4 == true)
                        <img style="width: 100%;" src="{{route('skin.image', 'ps4.png')}}" class="img-responsive" alt="Fortnitemall.gg Skin {{ $skin->name }}">
                    @endif
                    @if($skin->available_on_XBOX == true)
                        <img style="width: 100%;" src="{{route('skin.image', 'xbox.png')}}" class="img-responsive" alt="Fortnitemall.gg Skin {{ $skin->name }}">
                    @endif
                    @if($skin->available_on_SWITCH == true)
                        <img style="width: 100%;" src="{{route('skin.image', 'switch.png')}}" class="img-responsive" alt="Fortnitemall.gg Skin {{ $skin->name }}">
                    @endif
                </div>
            </div>
          </div>
          <div class="col-sm-9">
            <div class="product-body">
                <!-- <hr style="margin-top: 0px;"> -->
                <!-- <div style="font-size: 13px;  min-height: 56px; text-align: left; margin-left: 15px;"> -->
                <hr style="margin-top: 0px;">
                <div style="font-size: 1.5rem; font-weight: 700;  min-height: 3.5rem;">
                    {{ str_limit($skin->name, 40, "...") }} Test Test Season 8
                </div>


                  <span class="price" style="font-size: 1.2rem;">
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
                  <div style="font-size: 2rem; display: flex; justify-content: center; align-content: center;">
                    <form style="display: flex; align-items: center; width: 100%; justify-content: space-evenly;" id="add-to-cart-{{$skin->external_id}}" action="{{ route('cart.add', $skin->external_id) }}" method="POST">
                        {{ csrf_field() }}
                    </form>
                </div>
                  <div class="buttons">
                    <a href="{{route('cart.add', $skin->external_id)}}" class="btn btn-primary btn-sm btn-block add-to-cart" onclick="event.preventDefault(); document.getElementById('add-to-cart-{{$skin->external_id}}').submit();">
                        Details
                    </a>
                  </div>
              </div>
          </div>
      </div>
  </article>
</div>
