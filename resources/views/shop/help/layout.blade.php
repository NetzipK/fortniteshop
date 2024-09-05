@extends('layouts.shop')

@section('siteTitle')
Help Center
@endsection
@section('seo')
<meta name="description" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<meta name="og:title" property="og:title" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<link href="{{Request::url()}}" rel="canonical">
@endsection

@section('pageSpecificCSS')
<link href="{{URL::to('/')}}/assets/css/helpStyle.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

<div class="container-fluid" style="margin: 30px;">
    <div class="col-sm-4 col-md-3 help-menu">
        <ul class="list-unstyled">
            <li class="menu-highlight">FAQ</li>
            <li> <a href="{{route('help.paymentmethods')}}">Payment Methods</a> </li>
            <li class="menu-highlight">Legal</li>
            <li> <a href="{{route('help.legal.privacy')}}">Privacy Policy</a> </li>
            <li> <a href="{{route('help.legal.toc')}}">Terms and conditions</a> </li>
            <li> <a href="{{route('help.legal.cookies')}}">Cookie Policy</a> </li>
            <li> <a href="{{route('help.legal.row')}}">Right of Withdrawal</a> </li>
        </ul>
    </div>
    <div id="help-content" class="col-sm-8 col-md-9 help-content">
        @yield('help-content')
    </div>

</div>

@endsection

@section('pageSpecificJS')

<script src="{{URL::to('/')}}/assets/js/help-center.js"></script>

@endsection
