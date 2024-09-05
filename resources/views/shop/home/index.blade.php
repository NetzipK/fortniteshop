@extends('layouts.shop')

@section('siteTitle')
For the players, by the players
@endsection
@section('seo')
<meta name="description" content="Buy the amazing, cheapest Fortnite - Save the World items at fortnitemall.gg. Quick delivery, 24/7 online delivery and support. 100% trusted services.">
<meta property="og:title" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<link href="{{Request::url()}}" rel="canonical">
<meta property="og:type" content="website" />
<meta property="og:description" content="Buy the amazing, cheapest Fortnite - Save the World items at fortnitemall.gg. Quick delivery, 24/7 online delivery and support. 100% trusted services." />
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:site_name" content="FortniteMall.gg" />
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="Buy the amazing, cheapest Fortnite - Save the World items at fortnitemall.gg. Quick delivery, 24/7 online delivery and support. 100% trusted services." />
<meta name="twitter:title" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg." />


<meta property="og:image" content="{{URL::to('/')}}/assets/images/jumbotron/header_16.jpg">
@endsection

@section('content')
  @include('shop.partials.jumbotronVideo')
  @include('shop.partials.why-buy')
  @include('shop.partials.featuredProducts')
  {{-- @include('shop.partials.whatIsFortnite') --}}
@endsection
