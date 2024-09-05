{{--<header class="navbar navbar-default navbar-dark navbar-static-top" style="position: fixed; width: 100%; top: 0;">
  <div class="container">
        <div class="navbar-header">
            <a href="{{route('shop.home')}}" class="navbar-brand">
              <span>fortniteshop</span>.gg</a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></button>
            <!-- <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span>
            </button> -->
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
          <p class="navbar-text hidden-xs hidden-sm"></p>
          <ul class="nav navbar-nav navbar-right">

                <li>
                    <a href="{{route('shop.home')}}">Home</a>
                </li>
                <li>
                  <a href="{{route('shop.index')}}">STW Shop</a>
              </li>
              <li>
                  <a href="{{route('accounts.showbr')}}">Accounts</a>
              </li>
              <li>
                  <a href="{{route('skins.index')}}">Skins</a>
              </li>

              <li style="line-height: 50px;" class="hidden-xs">
                |
              </li>
              @auth
                    <li>
                        <a href="{{route('user.order.index')}}">
                            <i class="fa fa-user" aria-hidden="true"></i> My Account
                        </a>
                    </li>
                    <li>
                        <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out-alt" aria-hidden="true"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                    @endauth

                    {{-- Show this only for users thats are not logged in
                    {{--@guest
                    <li>
                      <a href="{{route('login')}}">
                          Login
                        </a>
                      </li>
                      <li>
                        <a href="{{route('register')}}">
                           Register
                        </a>
                      </li>
                    @endguest
                    <li style="line-height: 50px;" class="hidden-xs">
                      |
                    </li>
                <li class="dropdown navbar-cart">
                  <a href="{{route('cart.index')}}" >
                      Checkout <span style="{{Cart::count() > 0 ? 'color: #19A5D4;' : ''}}"><i class="fa fa-shopping-cart"></i> ({{Cart::content()->count()}})</span>
                  </a>
                    {{-- <ul class="dropdown-menu">

                      @if(Cart::count() > 0)
                        @foreach(Cart::content() as $article)
                        <li>
                          <div class="row">
                              <div class="col-sm-3">
                                <img src="{{asset('assets/images/articles/' . $article->model->image_name)}}" class="img-responsive" alt="Fortnitemall.gg Item Shopping Cart | {{$article->model->name }}">
                                </div>
                                <div class="col-sm-9">
                                <h4>
                                  <a href="{{route('article.show', $article->model->external_id) }}">
                                    {{$article->model->amount_step_size }}x {{$article->model->name }}
                                  </a>
                                </h4>
                                <p>{{$article->qty}}x - USD {{ number_format($article->total, 2)}}</p>
                                </div>
                            </div>
                        </li>
                        @endforeach

                        <!-- CART ITEM - START -->
                        <li>
                          <div class="row">
                              <div class="col-sm-12">
                                  <a href="{{route('cart.index')}}" class="btn btn-primary btn-block">Checkout</a>
                                </div>
                            </div>
                        </li>
                        <!-- CART ITEM - END -->
                      @else
                      <li>
                        <div class="row">
                          <img src="{{URL::to('/')}}/assets/images/fortnite/bus-01.png" alt="Fortnite Shop Empty Cart Bus" class="img-responsive">
                        </div>
                        <div class="row" style="margin-top: 3rem;">
                          <div class="col-sm-12 text-center">
                          <p style="margin-bottom: 2rem;">
                              Your shoppingcart is currently empty.
                            <a href="{{route('shop.index')}}">Make sure to add something!<br>
                              <i class="fa fa-arrow-right"></i>
                            </a>
                          </p>
                          </div>
                        </div>
                      </li>
                      @endif

                  </ul>
                </li>
            </ul>
        </div>
    </div>
</header>
--}}
<header class="navbar">
    <img src="{{URL::to('/')}}/assets/images/home/header/navbar_bg.png" alt="" class="navbar-logo-bg">
    <a href="{{route('shop.home')}}"><img src="{{URL::to('/')}}/assets/images/home/header/navbar_logo.png" alt="" class="navbar-logo"></a>
    <div class="social-media">
        <a href="https://www.facebook.com/fortnitemall.gg/" target="_blank"> <img src="{{URL::to('/')}}/assets/images/home/header/social-media/01_facebook.png" alt="Facebook"> </a>
        <a href="https://twitter.com/FortnitemallGG" target="_blank"> <img src="{{URL::to('/')}}/assets/images/home/header/social-media/02_twitter.png" alt="Twitter"> </a>
        <a href="https://www.instagram.com/fortnitemall.gg/" target="_blank"> <img src="{{URL::to('/')}}/assets/images/home/header/social-media/03_instagram.png" alt="Instagram"> </a>
        <a href="https://www.youtube.com/channel/UC5EMofcR_2O5Y-ZM6Xpyz-g" target="_blank"> <img src="{{URL::to('/')}}/assets/images/home/header/social-media/04_youtube.png" alt="YouTuber"> </a>
        <a href="https://discord.gg/dRYfzgm" target="_blank"> <img src="{{URL::to('/')}}/assets/images/home/header/social-media/05_discord.png" alt="Discord"> </a>
    </div>
    <button class="m_navIcon">
        <i class="fas fa-bars"></i>
    </button>
    <div class="header-top">
        <div class="nav nav-top">
            <ul>
                <li><a href="{{route('help.index')}}" style="color: #D4D219;">Help Center</a> </li>
                <li><a href="{{route('help.paymentmethods')}}">Payment Methods</a> </li>
                {{--<li><a href="#">FAQ</a> </li>
                <li><a href="#">Earn Money</a> </li>
                <li><a href="#">Loyalty Bonus</a> </li>
                <li><a href="#">Leaderboard</a> </li>--}}
            </ul>
        </div>
        <div class="nav nav-bottom">
            <ul>
                <li><a href="{{route('shop.index')}}">STW SHOP</a> </li>
                {{--<li><a href="#">STW SERVICES</a> </li>
                <li><a href="#">SPECIAL OF THE DAY</a> </li>
                <li><a href="#">TICKET RAFFLING</a> </li>--}}
                <li><a href="#" class="noclick">ACCOUNTS</a> </li>
                <li><a href="#" class="noclick">BR SKINS</a> </li>
            </ul>
        </div>
        {{--<div class="nav nav-right">
            <div class="custom-select">
                <select>
                  	<option value="0"></option>
                    <option value="1" selected>USD</option>
                    <option value="2">Euro</option>
                    <option value="3">CHF</option>
                </select>
            </div>
        </div>--}}
    </div>
    <div class="header-main">
        <div class="container-fluid">
            <div class="m_header-main-content">
                <button class="m_navIcon">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="nav-home">
                    <a href="{{route('shop.home')}}"><i class="fas fa-home"></i></a>
                </div>
                <div class="nav-search">
                    <span class="searchIcon"><i class="fas fa-search"></i></span>
                </div>
                @auth
                <div class="nav-wallet">
                    <a href="{{route('user.wallet')}}"><i class="fas fa-wallet"></i></a>
                </div>
                @endauth
                <div class="nav-user">
                    <a href="{{auth()->check() ? route('user.index') : route('login')}}"><i class="fas fa-user"></i></a>
                </div>
                <div class="nav-cart">
                    <a href="{{route('cart.index')}}"><i class="fas fa-shopping-cart"></i></a>
                </div>
                <div class="hideNav">
                    <ul style="height: calc(-100px + 100vh); top: 0px;">
                        <li class="m_nav"> <a href="{{route('shop.home')}}"><i class="fas fa-home"></i> Home</a> </li>
                        <li class="m_nav"> <a href="{{route('shop.index')}}">STW Shop</a> </li>
                        {{--<li class="m_nav"> <a href="#">STW Services</a> </li>
                        <li class="m_nav"> <a href="#">Special of the Day</a> </li>--}}
                    </ul>
                </div>
            </div>
            <div class="header-main-content">
                <div class="nav-home">
                    <a href="{{route('shop.home')}}" alt=""><i class="fas fa-home"></i> HOME</a>
                </div>
                <div class="search">
                    <form id="quick_find" method="POST">
                        <input type="search" name="keywords" placeholder="SEARCH ...">
                        <i class="fas fa-search"></i>
                    </form>

                    <div class="autocomplete-suggestions">
                        <div class="autocomplete-suggestion">
                            <div class="ac-img">
                                <img src="http://localhost/shop/articles/image/dragon%27s_roar.png" alt="">
                            </div>
                            <div class="ac-info">
                                <div class="ac-type">
                                    STW Item
                                </div>
                                <div class="ac-name">
                                    130 Dragon's Roar - Godroll - Fire
                                </div>
                                <div class="ac-link">
                                    <a href="http://localhost/shop/articles/7ee5f5a9-2a35-48bc-8ac5-42cfbf18c410" class="btn btn-primary">View Item</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @auth
                <div class="nav-icons nav-wallet clkMenu" id="clkMenu-wallet">
                    <a href="{{route('user.wallet')}}">
                        <i class="fas fa-wallet"></i> {{auth()->user()->wallet->getBalance(), 2}}$
                    </a>
                </div>
                @endauth
                <div class="nav-icons nav-user clkMenu" id="clkMenu-user">
                    <a href="{{auth()->check() ? route('user.index') : route('login')}}" alt="">
                        <i class="fas fa-user"></i> <i class="fas fa-angle-down"></i>
                    </a>
                    <div class="showLogin clkMenu-user_clkMenuBox">
                        @guest
                        <p>My Account</p>
						<form method="POST" action="{{route('login')}}">
                            @csrf
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<input type="email" name="email" class="form-control" placeholder="Email-Address" required>
							</div>
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
								<input type="password" name="password" class="form-control" placeholder="Password" required>
							</div>
							<a href="#" class="passwordForgotten">Forgot your password?</a>
                            <a href="{{route('register')}}" class="createAccount">Not registered yet?</a>
							<button type="submit" class="btn btn-primary btn-md btn-block login-btn"><i class="fas fa-sign-in-alt"></i> Login</button>
						</form>
                        @endguest
                        @auth
                        <p>{{auth()->user()->name}}</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{auth()->user()->getGGPercentageToNextLevel()}}" aria-valuemin="0" aria-valuemax="100" style="width: {{auth()->user()->getGGPercentageToNextLevel()}}%">

                            </div>
                        </div>
                        {!!str_repeat("<i class='fas fa-star level'></i> ", auth()->user()->getLoyaltyLevel())!!}
                        <span class="points">{{auth()->user()->getGGPoints()}} GG/{{auth()->user()->getLoyalyNextLevelPoints()}} GG</span>
                        <hr class="divider">
                        <div class="links-divider">
                            <a href="{{route('user.index')}}" style="font-weight: bold;"><i class="fas fa-user"></i> My Account</a>
                            {{--<hr class="link-divider">
                            <a href="{{route('user.notifications')}}" style="margin-left: 18px;">Notifications ({{auth()->user()->unreadNotifications->count()}})</a>--}}
                            <hr class="link-divider">
                            <a href="{{route('user.orders')}}" style="margin-left: 18px;">Orders</a>
                            <hr class="link-divider">
                            @if(auth()->user()->hasRole('Contributor'))
                            <a href="{{route('user.dcode')}}" style="margin-left: 18px;">Discount Codes</a>
                            <hr class="link-divider">
                            @endif
                            <a href="{{route('user.referrals')}}" style="margin-left: 18px;">Referrals</a>
                            <hr class="link-divider">
                            {{--
                            <a href="#" style="margin-left: 18px;">GG Points</a>
                            <hr class="link-divider">
                            --}}
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-weight: bold;"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                        @endauth
                    </div>
                </div>
                <div class="nav-icons nav-cart clkMenu" id="clkMenu-cart">
                    <a href="{{route('cart.index')}}">
                        <i class="fas fa-shopping-cart"></i> <i class="fas fa-angle-down"></i>
                    </a>
                    <ul class="showCart clkMenu-cart_clkMenuBox">
                        @if(Cart::count() > 0)
                            <table>
                                <thead>
                                    <th></th>
                                    <th>Quantity</th>
                                    <th>Article</th>
                                    <th>Price</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach(Cart::content() as $article)
                                    <tr id="shoppingcart-article-{{$article->id}}">
                                        <td class="col-xs-2"><img src="{{route('article.image', $article->model->image_name)}}" alt="Fortnitemall.gg article Shopping Cart | {{$article->model->name }}" class="img-responsive"></td>

                                        <td><span>x{{$article->qty}}</span></td>

                                        <td class="">
                                            <a href="{{route('article.show', $article->model->external_id)}}">
                                                {{$article->model->name}}
                                            </a>
                                        </td>

                                        <td class=""><span>USD {{number_format($article->total,2)}}</span></td>

                                        <td class="text-center">
                                            <form id="delete-quantity-{{$article->model->external_id}}" action="{{ route('cart.delete', $article->model->external_id) }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                            <button class="btn btn-danger delete-article" data-article-id="{{$article->id}}" onclick="event.preventDefault(); document.getElementById('delete-quantity-{{$article->model->external_id}}').submit();">
                                                <i id="shoppingcart-delete-{{$article->id}}" class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="cart-subtotal">
                                <p>Subtotal:<span> {{Cart::subtotal(2, '.')}}</span></p>
                            </div>
                            {{--<li>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="{{asset('assets/images/articles/' . $article->model->image_name)}}" class="img-responsive" alt="Fortnitemall.gg Item Shopping Cart | {{$article->model->name }}">
                                    </div>
                                    <div class="col-sm-9">
                                        <h4>
                                            <a href="{{route('article.show', $article->model->external_id) }}">
                                                {{$article->model->amount_step_size }}x {{$article->model->name }}
                                            </a>
                                        </h4>
                                        <p>{{$article->qty}}x - USD {{ number_format($article->total, 2)}}</p>
                                    </div>
                                </div>
                            </li>--}}

                        <!-- CART ITEM - START -->
                        <li>
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="{{route('cart.index')}}" class="btn btn-danger btn-block showCart-btn"><i class="fas fa-trash-alt"></i> Remove all</a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{route('cart.index')}}" class="btn btn-primary btn-block showCart-btn"><i class="fas fa-shopping-cart"></i> Go to cart</a>
                                </div>
                            </div>
                        </li>
                        <!-- CART ITEM - END -->
                        @else
                        <li>
                            Your shopping cart is currently empty.
                        </li>
                        <li>
                            <a href="{{route('shop.index')}}" class="btn btn-primary btn-md btn-block login-btn">
                                Make sure to add something!
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="commScroll">

    </div>
</header>
