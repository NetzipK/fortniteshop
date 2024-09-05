@extends('layouts.shop')

@section('siteTitle')
Wallet
@endsection
@section('seo')
<meta name="description" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<meta name="og:title" property="og:title" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<link href="{{Request::url()}}" rel="canonical">
@endsection

@section('pageSpecificCSS')

@endsection

@section('content')
<div class="container">
    <div style="margin-top: 200px; color: black; text-align: center; background-color: #FFF;">
        <form action="{{route('giftcard.create')}}" method="post">
            @csrf
            <input type="text" name="amount" placeholder="Amount" required>
            <button type="submit" name="button">Add Funds</button>

        </form>
    </div>
</div>
@endsection
