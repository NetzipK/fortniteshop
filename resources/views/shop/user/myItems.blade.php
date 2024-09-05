@extends('shop.user.layout')

@section('content-menu')
<div class="content-menu col-sm-9" id="profile-content">
    <div class="menu-tabs">
        @if($items->count() > 0)
        @foreach($items as $item)
        <button class="tablinks" onclick="openTab(event, `{{$item->name}}`)" @if($loop->first) id="defaultOpen" @endif>{{str_limit($item->name, 18, "...")}}</button>
        @endforeach
        @else
        <button class="tablinks" onclick="openTab(event, 'My Items')" id="defaultOpen">My Items</button>
        @endif
    </div>

    <div class="tab-content-bg">
        @if($items->count() > 0)
        @foreach($items as $item)
        <div class="tabcontent" id="{{$item->name}}">
            <div class="bg-light item-info">
                <img src="{{route('article.image', $item->image_name)}}" class="img-responsive" alt="Fortnitemall.gg Item {{ $item->name }}">
                <div class="info-text">
                    <p>{{$item->name}}</p>
                    <p>Price: {{number_format($item->price, 2, ',', '.')}}$</p>
                    <p>Your Revenue: {{$item->owner_revenue}}%</p>
                    <p>Total Items Sold: {{$item->getSoldCount()}}</p>
                    <p>Your Total Revenue: {{$item->getSoldRevenue()}}$</p>
                    <p> <a href="{{route('article.show', $item->external_id)}}">{{route('article.show', $item->external_id)}}</a> </p>
                </div>

            </div>
        </div>
        @endforeach
        @else
        <div class="tabcontent" id="My Items">
            <div class="bg-light discount-code">
                <span>Imagine having your own item or even a bundle which contains a set of items of your own!</span>
                <span>Imagine getting a percentage off of every sale to your own wallet, which can be transfered to real money!</span>
                <span>With us, it's possible! Contact an Admin now via Discord to come to a deal which can benefit both parties!</span>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
