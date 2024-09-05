@extends('layouts.shop')

@section('siteTitle')
Register
@endsection
@section('seo')
<meta name="description" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<meta name="og:title" property="og:title" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<link href="{{Request::url()}}" rel="canonical">
@endsection

@section('content')
<section class="content account" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_19.jpg); background-position: center 0%; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-8 col-md-4">
                <div class="login-form-wrapper">

                    {{-- Register Form --}}
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <h3>Register your Fortnitemall Account</h3>
                        <p style="margin-bottom: 3rem;">
                            Register your account for quicker purchases, exclusive content, amazing deals and lots of additional advantages.
                        </p>
                        <hr>

                        {{-- Name --}}
                        <div class="form-group">
                            <label>Name<span class="required">*</span></label>
                            <input id="name" type="text" placeholder="Max Mustermann" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <label>Your Email Adress<span class="required">*</span></label>
                            <input id="email" type="email" placeholder="fortnite@shop.gg" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- Epic Id --}}
                        <div class="form-group">
                            <label>Your Epic Id<span class="required">*</span></label>
                            <input id="epic_id" type="text" placeholder="EpicId009" class="form-control{{ $errors->has('epic_id') ? ' is-invalid' : '' }}" name="epic_id" value="{{ old('epic_id') }}" required autofocus>
                            @if ($errors->has('epic_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('epic_id') }}</strong>
                                </span>
                            @endif
                            <p style="line-height: 16px; margin-top: 0.5rem;"><i class="fa fa-question-circle "></i> How to find your <a href="{{route('guides.findYourEpicId')}}" target="_blank">Epic Id?</a></p>
                        </div>

                        <hr>

                        {{-- Password --}}
                        <div class="form-group">
                            <label>Your Password<span class="required">*</span></label>
                            <input id="password" type="password" placeholder="**********" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{-- Confirm Password --}}
                        <div class="form-group">
                            <label>Confirm Password<span class="required">*</span></label>
                            <input id="password-confirm" placeholder="**********" type="password" class="form-control" name="password_confirmation" required>
                        </div>



                        <hr>

                        {{-- Discord Id --}}
                        <div class="form-group">
                            <label>Your Discord Id (optional)</label>
                            <input id="discord_id" type="text" placeholder="nickname#1234" class="form-control" name="discord_id" value="{{ old('discord_id') }}" autofocus>
                            <p style="line-height: 16px; margin-top: 0.5rem;"><i class="fa fa-arrow-right"></i> Join us on <a href="https://discord.gg/tWMZdRv" target="_blank">Discord</a></p>  
                        </div>


                        {{-- Plattform --}}
                        <div class="form-group">
                            <label for="platform">Select your platform</label>
                            <select class="form-control" id="platform" name="platform">
                              <option>PC</option>
                              <option>PS4</option>
                              <option>XBOX</option>
                            </select>
                          </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Register now</button>
                        <div style="margin-top: 1rem;">Already a member? Then <a href="{{route('login')}}">login now</a></div>
                    </form>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
