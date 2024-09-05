<!DOCTYPE html>
<html>
<head>
    {{-- Meta --}}
    <meta http-equiv="Content-Typ#e" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="{{URL::to('/')}}/favicon.ico">

    {{-- CSRF token for Laravel --}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Title --}}
    <title>fortnitemall.gg | @yield('siteTitle')</title>
    @yield('seo')

    {{-- Fonts --}}
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Luckiest+Guy|Open+Sans">
    <link href="https://fonts.googleapis.com/css?family=Palanquin:400,600|Roboto:400,900" rel="stylesheet">

    <style>
    #announcement {
        position: fixed;
        top: 70px;
        height: 50px;
        width: 100%;
        z-index: 6000;
        line-height: 50px;
        text-align: center;
        {{is_null($announcement) ? '' : 'background-color: ' . $announcement->bannerColor . ';'}}
        {{is_null($announcement) ? '' : 'color: ' . $announcement->textColor . ';'}}
    }
    #note {
        position: fixed;
        @if(!is_null($announcement))
        top: 100px;
        @else
        top:50px;
        @endif
        left: 5px;
        width: 100%;
        z-index: 1000;
    }
    #note img {
        cursor: pointer;
    }
    #note .discord-logo {
        width: 80px;
    }
    #note .join-discord {
        position: absolute;
        top: 7px;
        left: 58px;
        width: 300px;
        display: none;
    }
    #note .no-discord {
        position: absolute;
        top: 106px;
        left: 58px;
        width: 300px;
        display: none;
    }
    #note a:hover + .no-discord {
        display: block;
    }
    #note .no-discord:hover {
        display: block;
    }

    #accept-cookies {
        position: fixed;
        @if(!is_null($announcement))
        top: 200px;
        @else
        top:150px;
        @endif
        right: 1px;
        width: 350px;
        z-index: 1000;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        font-size: 12px;
    }
    #accept-cookies .cookies-text {
        margin: 10px 10px 0 10px;
    }
    #accept-cookies .cookies-learn-more {
        margin: -10px 10px;
        font-size: 10px;
        text-decoration: underline;
    }
    #accept-cookies .accept-cookies-div {
        margin: 15px 0 20px;
        text-align: center;
    }
    #accept-cookies .accept-cookies-btn {
        background-color: #ffd633;
    	cursor: pointer;
    	color: #000000;
    	font-size: 14px;
    	padding: 10px 60px;
    }
    #accept-cookies .accept-cookies-btn:hover {
    	background-color: #e6b800;
    }
    @if(!is_null($announcement))
    #content {
        margin-top: 20px;
    }
    @endif
    </style>

    {{-- CSS --}}
    <link href="{{URL::to('/')}}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="{{URL::to('/')}}/assets/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="{{URL::to('/')}}/assets/css/dragtable.css" rel="stylesheet" type="text/css">
    <link href="{{URL::to('/')}}/assets/css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="{{URL::to('/')}}/assets/css/animate.css" rel="stylesheet" type="text/css">
    <link href="{{URL::to('/')}}/assets/css/color-switcher.css" rel="stylesheet" type="text/css">
    <link href="{{URL::to('/')}}/assets/css/custom.css" rel="stylesheet" type="text/css">
    <link href="{{URL::to('/')}}/assets/css/color/blue.css" id="main-color" rel="stylesheet" type="text/css">
    <link href="{{URL::to('/')}}/assets/css/home.css?v=1" rel="stylesheet" type="text/css">

    @yield('pageSpecificCSS')

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script src="{{URL::to('/')}}/assets/js/owl.carousel.min.js"></script>
    <script src="{{URL::to('/')}}/assets/js/home.js"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- TrustBox script --> <script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script> <!-- End TrustBox script -->
</head>
<body>
    <div id="scrolltop" class="hidden-xs"><i class="fa fa-angle-up"></i></div>
    <div id="page-wrapper">
        {{-- @include('shop.menu.topNavigation') --}}
        @include('shop.menu.mainNavigation')
        {{-- @include('shop.partials.newsletter') --}}
        {{-- @include('shop.partials.categoryBlocks') --}}
        <div id="content">
            @yield('content')
        </div>
        {{-- @include('shop.partials.testmonials') --}}
        @include('shop.partials.footer')
    </div>

    @if(!is_null($announcement))
    <div id="announcement">
        {!!$announcement->text!!}
    </div>
    @endif

    {{--@if(Cookie::get('no-discord') === null)
    <div id="note">
        <img class="discord-logo" src="{{URL::to('/')}}/assets/images/others/Logo.png" alt="">
        <a href="https://discord.gg/tWMZdRv" target="_blank"><img src="{{URL::to('/')}}/assets/images/others/Button.png" class="join-discord" alt=""> </a>
        <img src="{{URL::to('/')}}/assets/images/others/cookie_no.png" class="no-discord" alt="">
    </div>
    @endif--}}

    @if(Cookie::get('cookies-accepted') === null)
    <div id="accept-cookies">
        <div class="cookies-text">
            We are using cookies to provide you with the best experience on our website. By continuing using our site, you agree to our use of cookies.
        </div>
        <a href="{{route('legal.cookie')}}" class="cookies-learn-more">Learn more</a>
        <div class="accept-cookies-div">
            <a class="accept-cookies-btn">I accept</a>
        </div>
    </div>
    @endif

    @if(Session::has('modalPopup'))
    <!-- Modal -->
    <div class="modal-wrapper">
        <div class="modal">
            <div class="head">
                <a class="btn-close trigger" href="#">
                <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
            <div class="content">
                <div class="good-job">
                <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                <h1>{{Session::get('modalPopup')}}</h1>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- JS --}}
	<script src="{{URL::to('/')}}/assets/js/bootstrap.min.js"></script>
    <script src="{{URL::to('/')}}/assets/js/SmoothScroll.js"></script>
    <script src="{{URL::to('/')}}/assets/js/jquery.card.js"></script>
    {{-- <script src="{{URL::to('/')}}/assets/js/jquery.mb.YTPlayer.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@11.0.6/dist/lazyload.min.js"></script>
    {{-- <script src="{{URL::to('/')}}/assets/js/custom.js"></script> --}}

    @yield('pageSpecificJS')

    {{-- Support tracking code --}}
    <!-- Start of LiveChat (www.livechatinc.com) code -->
    <script type="text/javascript">
    window.__lc = window.__lc || {};
    window.__lc.license = 10807857;
    (function() {
      var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
      lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
    })();
    </script>
    <noscript>
    <a href="https://www.livechatinc.com/chat-with/10807857/" rel="nofollow">Chat with us</a>,
    powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a>
    </noscript>
    <!-- End of LiveChat code -->

    <script>
        $(document).ready(function() {
            var clickedLogo = false;
            $('.discord-logo').on('click', function(e) {
                e.stopPropagation();
                if(clickedLogo) {
                    clickedLogo = false;
                    $('.join-discord').hide();
                }
                else {
                    clickedLogo = true;
                    $('.join-discord').show();
                }
            });
            $(document).click(function() {
                if(clickedLogo) {
                    clickedLogo = false;
                    $('.join-discord').hide();
                }
            });
            $('.no-discord').on('click', function() {
                $.ajax({
                    url: '/discord/no-discord-session'
                });
                $('#note').remove();
            });
            $('.accept-cookies-btn').on('click', function() {
                $.ajax({
                    url: '/legal/accept-cookies'
                });
                $('#accept-cookies').remove();
            });
            $('.trigger').on('click', function() {
                $('.modal-wrapper').toggleClass('open');
                $('.page-wrapper').toggleClass('blur-it');
                return false;
            });
            @if(Session::has('modalPopup'))
                $('.modal-wrapper').toggleClass('open');
                $('.page-wrapper').toggleClass('blur-it');
            @endif
        });
    </script>

</body>
</html>
