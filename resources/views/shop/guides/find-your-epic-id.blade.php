@extends('layouts.shop')

@section('content')
<section class="lazy content jumbotron jumbotron-video-5" data-bg="url({{asset('/assets/images/jumbotron/header_15.jpg')}})" style="margin-top: 50px;">
</section>
<section class="content products">
  <div class="container">
      <div class="row">
          <h1 class="component-heading" id="headings">How to find your Epic Name?</h1>
          <hr>

          <p>Following these steps and providing us your EPIC Name without typos will make the delivery faster.</p>

          <h2 class="component-heading" id="headings">Step 1</h2>
          <hr>
          <p>First sign into your account at the official Fortnite website:<a href="https://www.epicgames.com/site/en-US/home" target="_blank">Epic Games</a></p>
          <img class="img img-responsive" style="max-width: 750px; margin-bottom: 3rem;" src="{{asset('assets/images/guides/how-to-find-your-epic-id/epic-id-01.jpg')}}" alt="fortnitemall.gg | How to find your epic id | Step 1">

          <h2 class="component-heading" id="headings">Step 2</h2>
          <hr>
          <p>Sign in using your account email adress and password.</p>
          <img class="img img-responsive" style="max-width: 750px; margin-bottom: 3rem;" src="{{asset('assets/images/guides/how-to-find-your-epic-id/epic-id-02.jpg')}}" alt="fortnitemall.gg | How to find your epic id | Step 2">


          <h2 class="component-heading" id="headings">Step 3</h2>
          <hr>
          <p>Check the top right corner of your screen. That is your EPIC Name.</p>
          <img class="img img-responsive" style="max-width: 750px;" src="{{asset('assets/images/guides/how-to-find-your-epic-id/epic-id-03.jpg')}}" alt="fortnitemall.gg | How to find your epic id | Step 3">
      </div>
  </div>
</section>
@endsection
