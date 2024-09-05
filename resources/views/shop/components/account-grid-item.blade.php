<!-- <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xs-6 article-grid-item" style="max-width:235px;"> -->
<!-- <div class="col-sm-4 col-md-2 col-lg-5 col-xl-3 col-xs-5 article-grid-item" style="max-width:235px;"> -->
<div class="col-sm-4 col-md-2 col-xl-3 col-lg-5 col-xs-5 article-grid-item" style="max-width:218px;">
  <article class="product-item" id="product-item">
    <div class="row">
        <div class="col-sm-3 accounts-overlay-filters" style="display: flex; justify-content: center; min-height: 15rem; align-items: center;">
            <div class="product-overlay">
                {{-- <div class="product-mask"></div> --}}
                <a href="{{route('account.show', $account->external_id)}}" class="product-permalink"></a>
                <div class="account-container">
                    @if($account->full_access == true && Route::currentRouteName() === 'accounts.showbr')
                    <img style="height: 100%;" src="{{asset('/assets/images/accounts/br/01_full_access.png')}}" class="img-responsive" alt="Fortnitemall.gg Item {{ $account->name }}">
                    @elseif($account->full_access == false && Route::currentRouteName() === 'accounts.showbr')
                    <img style="height: 100%;" src="{{asset('/assets/images/accounts/br/02_half_access.png')}}" class="img-responsive" alt="Fortnitemall.gg Item {{ $account->name }}">
                    @endif
                    @if($account->full_access == true && Route::currentRouteName() === 'accounts.showstw')
                    <img style="height: 100%;" src="{{asset('/assets/images/accounts/stw/01_full_access.png')}}" class="img-responsive" alt="Fortnitemall.gg Item {{ $account->name }}">
                    @elseif($account->full_access == false && Route::currentRouteName() === 'accounts.showstw')
                    <img style="height: 100%;" src="{{asset('/assets/images/accounts/stw/02_half_access.png')}}" class="img-responsive" alt="Fortnitemall.gg Item {{ $account->name }}">
                    @endif
                    {{-- <img src="assets/images/products/product-1b.jpg" class="img-responsive product-image-2" alt=""> --}}
                    {{-- <div class="product-quickview">
                        <a class="btn btn-quickview" data-toggle="modal" data-target="#product-quickview">Quick View</a>
                    </div> --}}
                    @if(Route::currentRouteName() === 'accounts.showbr')
                    <div class="account-level"> <!-- LEVEL -->
                        100
                    </div>
                    <div class="account-vbucks"> <!-- VBUCKS -->
                        1,200
                    </div>
                    <div class="account-skins color"> <!-- SKINS -->
                        210
                    </div>
                    <div class="account-pickaxes color"> <!-- PICKAXES -->
                        58
                    </div>
                    <div class="account-gliders color"> <!-- GLIDERS -->
                        43
                    </div>
                    <div class="account-backblings color"> <!-- BACKBLINGS -->
                        21
                    </div>
                    <div class="account-dances color"> <!-- DANCES -->
                        13
                    </div>
                    @if($account->pve == false)
                    <div class="account-not-pve"> <!-- NOT PVE -->
                        <strong>no</strong>
                    </div>
                    @else
                    <div class="account-pve color"> <!-- PVE -->
                        <strong>yes</strong>
                    </div>
                    @endif
                    @elseif(Route::currentRouteName() === 'accounts.showstw')
                    <div class="account-level-stw">
                        131
                    </div>
                    <div class="account-vbucks-stw">
                        1,200
                    </div>
                    @if($account->standard_edition == true)
                    <div class="standard-edition">
                        STANDARD
                    </div>
                    @endif

                    @if($account->deluxe_edition == true)
                    <div class="deluxe-edition">
                        DELUXE
                    </div>
                    @endif

                    @if($account->super_deluxe_edition == true)
                    <div class="super-deluxe-edition">
                        <span style="letter-spacing: 0;">SUPER</span> DELUXE
                    </div>
                    @endif
                    <div class="edition">
                        EDITION
                    </div>
                    <div class="account-campagne">
                        T1: Stonewood
                        @if($account->campagne === 'T1')
                        T1: Stonewood
                        @endif
                        @if($account->campagne === 'T2')
                        T2: Plankerton
                        @endif
                        @if($account->campagne === 'T3')
                        T3: Canney Valley
                        @endif
                        @if($account->campagne === 'T4')
                        T4: Twine Peaks
                        @endif
                    </div>
                    @endif
                </div>
              </div>
          </div>
          <div class="col-sm-9">
            <div class="product-body">
                <hr style="margin-top: 0px;">
                <div style="font-size: 1.5rem; font-weight: 700;  min-height: 58px;">
                    {{ str_limit($account->name, 40, "...") }}
                </div>

                <div class="product-labels">
                    @if($account->is_featured)
                        <span class="label label-success">Featured</span>
                    @endif
                    @if($account->is_sale)
                        <span class="label label-danger">sale</span>
                    @endif
                </div>
                  <span class="price" style="font-size: 1.2rem;">
                    {{-- <del><span class="amount">
                            USD <span id="oldPrice-{{$account->external_id}}">
                            {{ number_format($account->price + 1, 2)}}
                            </span>
                        </span>
                    </del> --}}
                    <ins>
                        <span class="amount text-danger" style="font-size: 2rem;">
                            USD <span id="newPrice-{{$account->external_id}}">{{ number_format($account->price, 2) }}</span>
                        </span>
                    </ins>
                  </span>
                  <!-- <div style="font-size: 2rem; display: flex; justify-content: center; align-content: center;">
                    <form style="display: flex; align-items: center; width: 100%; justify-content: space-evenly;" id="add-to-cart-{{$account->external_id}}" action="{{ route('cart.add', $account->external_id) }}" method="POST">
                        {{ csrf_field() }}
                    </form>
                </div> -->
                  <!-- <hr style="margin-bottom: 0px; margin-top: 10px;"> -->
                  <div class="buttons">
                    <a href="{{route('account.show', $account->external_id)}}" class="btn btn-primary btn-sm btn-block add-to-cart">
                        Details
                    </a>
                  </div>
              </div>
          </div>
      </div>
  </article>
</div>
