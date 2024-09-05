@extends('shop.user.layout')

@section('content-menu')
<div class="content-menu col-sm-9" id="profile-content">
    <div class="menu-tabs">
        <button class="tablinks active" onclick="openTab(event, 'Balance')" id="defaultOpen">Balance</button>
        <button class="tablinks" onclick="openTab(event, 'Withdraw')">Withdraw</button>
        <button class="tablinks" onclick="openTab(event, 'Transactions')">Transactions</button>
    </div>

    <div class="tab-content-bg">
        <div class="" id="Balance">

        </div>
        <div class="" id="Withdraw">

        </div>
        <div class="" id="Transactions">

        </div>
    </div>
</div>
@endsection
