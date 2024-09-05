@extends('shop.user.layout')

@section('content-menu')
<div class="content-menu col-sm-9" id="profile-content">
    <div class="menu-tabs">
        <button class="tablinks active" onclick="openTab(event, 'Referrals')" id="defaultOpen">Referrals</button>
    </div>

    <div class="tab-content-bg">
        <div class="tabcontent" id="Referrals">
            <div class="bg-light referral">
                Referral link
                <div class="copy-to-clip">
                    <input id="copyInput" onClick="this.setSelectionRange(0, this.value.length)" type="text" name="reflink" value="{{route('shop.home') . '?ref=' . \Hashids::encode(auth()->user()->id)}}" readonly>
                    <div class="copy-tooltip">
                        <button type="button" onclick="copyToClip()" onmouseout="mouseOutCopy()">
                            <span class="tooltiptext" id="myTooltip">Copy to clipboard</span>
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
                <span>Number of referral uses: {{auth()->user()->wallet->getRefUses()}}</span>
                <span>Total Revenue($): {{auth()->user()->wallet->getRefRevenue()}}$</span>
            </div>
        </div>
    </div>
</div>
@endsection
