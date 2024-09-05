@extends('layouts.shop')

@section('siteTitle')
Login
@endsection
@section('seo')
<meta name="description" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<meta name="og:title" property="og:title" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<link href="{{Request::url()}}" rel="canonical">
@endsection

@section('content')
<section class="content account" style="background: url({{URL::to('/')}}/assets/images/jumbotron/header_29.jpg); background-position: center 25%; background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-8 col-md-4">
                <div class="login-form-wrapper">

                    {{-- Login Form --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <h3>Your Fortnitemall Login</h3>
                        <p style="margin-bottom: 3rem;">
                            Login with your Fortnitemall.gg account to gain access to your recent orders, exclusive content and additional informations.
                        </p>
                        <hr>

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

                        {{-- Remember me --}}
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" id="signin-remember">
                                <label for="signin-remember">Remember me</label>
                            </div>
                        </div>
                        <hr>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                        <div style="margin-top: 1rem;">Not a Member? You are missing exclusive deals. <a href="{{route('register')}}">Register now</a></div>
                    </form>

                    <hr>

                    {{-- Image --}}
                    <img style="margin-left: auto; margin-right: auto; width: 100%;" class="img img-responsive" src="{{asset("assets/images/fortnite/register-wp-new.jpg")}}" alt="Fortnitemall.gg | Login Image">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
