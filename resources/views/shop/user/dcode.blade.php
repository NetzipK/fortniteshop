@extends('shop.user.layout')

@section('content-menu')
<div class="content-menu col-sm-9" id="profile-content">
    <div class="menu-tabs">
        <button class="tablinks active" onclick="openTab(event, 'Discount Code')" id="defaultOpen">Discount Code</button>
    </div>

    <div class="tab-content-bg">
        <div class="tabcontent" id="Discount Code">
            @if (Session::has('dc-success'))
            <div class="alert alert-success" role="alert">
               Discount Code successfully updated.
            </div>
            @endif
            @if (Session::has('dc-error'))
            <div class="alert alert-danger" role="alert">
               Discount Code update failed. If this keeps happening please contact an Admin.
            </div>
            @endif
            <div class="bg-light discount-code">
                @if(is_null($dcode))
                <span>Wouldn't you like to have your own discount code? Everyone would!</span>
                <span>You can contact an Admin via Discord to come to a deal which can benefit both parties.</span>
                @else
                Discount Code
                <form class="form-inline" method="post" action="{{route('user.changedcode')}}">
                    @csrf
                    <div class="form-group">
                        <label class="sr-only" for="discountcode">Discount Code</label>
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fas fa-qrcode"></i></div>
                            <input id="discountcode" type="text" class="form-control" name="code" value="{{$dcode->code}}" minlength="4" maxlength="10" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" @if(!$dcode->active) disabled @endif>Apply Changes</button>
                    @if(!$dcode->active) <span style="color: red;">Discount Code is disabled!</span> @endif
                </form>
                <span>Customers Discount: {{$dcode->discount}}%</span>
                <span>Your Revenue: {{$dcode->getRevenue($dcode)}}%</span>
                <span>Number of code uses: {{$dcode->user->wallet->getDCUses()}}</span>
                <span>Total Revenue($): {{$dcode->user->wallet->getDCRevenue()}}$</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
