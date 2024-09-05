@extends('layouts.shop')

@section('siteTitle')
Profile
@endsection
@section('seo')
<meta name="description" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<meta name="og:title" property="og:title" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<link href="{{Request::url()}}" rel="canonical">
@endsection

@section('pageSpecificCSS')
<link href="{{URL::to('/')}}/assets/css/userStyle.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

<div class="container profile-box">
    <div class="profile-left col-sm-3">
        <div class="user-name">
            {{auth()->user()->name}}
        </div>
        <div class="profile-menu">
            {{--<div class="menu-item">
                <a href="{{route('user.index')}}" class="item-link">Notifications <span>16</span></a>
            </div>--}}
            <div class="menu-item">
                <a href="{{route('user.wallet')}}" class="item-link">Wallet</a>
            </div>
            <div class="menu-item">
                <a href="{{route('user.orders')}}" class="item-link">Orders</a>
            </div>
            @if(auth()->user()->hasRole('Contributor'))
            <div class="menu-item">
                <a href="{{route('user.dcode')}}" class="item-link">Discount Code</a>
            </div>
            <div class="menu-item">
                <a href="{{route('user.myItems')}}" class="item-link">My Items</a>
            </div>
            @endif
            <div class="menu-item">
                <a href="{{route('user.referrals')}}" class="item-link">Referrals</a>
            </div>
            {{--<div class="menu-item">
                <a href="{{route('user.ggpoints')}}" class="item-link">GG Points <span>1</span></a>
            </div>
            <div class="menu-item">
                <a href="{{route('user.settings')}}" class="item-link">Settings</a>
            </div>--}}
            <div class="menu-item">
                <a href="#" class="item-link" onclick="event.preventDefault(); document.getElementById('logout-form-profile').submit();">Log Out</a>
            </div>
            <form id="logout-form-profile" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>


    </div>
    <div id="content-menu">
        @yield('content-menu')
    </div>

</div>

@endsection

@section('pageSpecificJS')

<script src="{{URL::to('/')}}/assets/js/profile.js"></script>

@endsection
