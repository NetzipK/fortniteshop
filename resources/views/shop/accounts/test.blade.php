<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/ion.rangeSlider.css">
        <link rel="stylesheet" href="css/filterstyle.css">
        <meta name="theme-color" content="#fafafa">
    </head>
    <body>
        <!--[if IE]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <div id="filters">
            <div id="email-access-filter">
                <h5>Full E-Mail Access</h5>
                <input type="radio" name="email_access" value="both" id="both" checked /><label for="both">Both <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                <input type="radio" name="email_access" value="yes" id="yes" /><label for="yes">Yes <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
                <input type="radio" name="email_access" value="no" id="no" /><label for="no">No <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" style="position: absolute; width: 9px; margin-top: -23px; margin-left: 88px; display: block;"> </label>
            </div>
            <div id="platform2-filter">
                <h5>Platform</h5>
                <input type="checkbox" class="platform_type_checkbox" id="platform_pc" name="platform_pc" value="1" /><label for="platform_pc"> <img src="{{URL::to('/')}}/assets/images/others/windows.png" alt="PC"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                <input type="checkbox" class="platform_type_checkbox" id="platform_ps4" name="platform_ps4" value="1" /><label for="platform_ps4"> <img src="{{URL::to('/')}}/assets/images/others/ps4.png" alt="PS4"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                <input type="checkbox" class="platform_type_checkbox" id="platform_xbox" name="platform_xbox" value="1" /><label for="platform_xbox"> <img src="{{URL::to('/')}}/assets/images/others/xbox.png" alt="XBOX"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
            </div>

            <div id="type-filter">
                <h5>Account Type</h5>
                <input type="checkbox" class="account_type_checkbox" name="type_br" id="type_br" value="1" /> <label for="type_br">Battle Royale</label>
                <input type="checkbox" class="account_type_checkbox" name="type_stw" id="type_stw" value="1" /><label for="type_stw">Save The World</label>
            </div>

            <div id="platform-filter">
                <h5>Platform</h5>
                All <input type="radio" name="platform" value="all" checked />
                PS4 <input type="radio" name="platform" value="ps4" />
                PC <input type="radio" name="platform" value="pc" />
                Xbox <input type="radio" name="platform" value="xbox" />
            </div>

            <br /> <br />

            <div id="price-filter">
                <h5>Price</h5>
                <label style="position:absolute; margin-top: 31px; margin-left: -180px;" id="fromPrice">0</label>
                <label style="position:absolute; margin-top:31px; margin-left: 170px;" id="toPrice">0</label>
                <input type="text" class="js-range-slider" name="my_range" value="" />
            </div>
        </div>

        <br /><br /><br /><br />

        <div id="accounts-container">
            @foreach($accounts as $account)
                <div class="account">
                    <p class="name">{{$account->name}}</p>
                    <p class="pve">Is PVE: {{$account->pve}}</p>
                    <p class="vbucks">VBucks: {{$account->vbucks}}</p>
                    <p class="price">{{number_format($account->price, 2)}}</p>
                    <a href="{{route('cart.add', $account->external_id)}}">Details</a>
                </div>
            @endforeach
        </div>

        <!-- <div id="accounts-container">
            <div class="account">
                <p class="name">Fortnite Account</p>
                <p class="rank">Silver</p>
                <p class="platform">PS4</p>
                <p class="vbucks">5000</p>
                <p class="price">10.00€</p>
                <a href="#" class="link">Buy Now</a>
            </div>

            <div class="account">
                <p class="name">Fortnite Account</p>
                <p class="rank">Silver</p>
                <p class="platform">Xbox</p>
                <p class="vbucks">5000</p>
                <p class="price">10.00€</p>
                <a href="#" class="link">Buy Now</a>
            </div>

            <div class="account">
                <p class="name">Fortnite Account</p>
                <p class="rank">Gold</p>
                <p class="platform">PC</p>
                <p class="vbucks">5000</p>
                <p class="price">10.00€</p>
                <a href="#" class="link">Buy Now</a>
            </div>

            <div class="account">
                <p class="name">Fortnite Account</p>
                <p class="rank">Bronze</p>
                <p class="platform">PS4</p>
                <p class="vbucks">5000</p>
                <p class="price">10.00€</p>
                <a href="#" class="link">Buy Now</a>
            </div>

            <div class="account">
                <p class="name">Fortnite Account</p>
                <p class="rank">Bronze</p>
                <p class="platform">PS4</p>
                <p class="vbucks">5000</p>
                <p class="price">10.00€</p>
                <a href="#" class="link">Buy Now</a>
            </div>
        </div> -->

        <script src="{{URL::to('/')}}/js/vendor/modernizr-3.7.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="{{URL::to('/')}}/js/vendor/ion.rangeSlider.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{URL::to('/')}}/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
        <script src="{{URL::to('/')}}/js/plugins.js"></script>
        <script src="{{URL::to('/')}}/js/main.js"></script>
    </body>
</html>
