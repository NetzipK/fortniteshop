@extends('shop.user.layout')

@section('content-menu')
<div class="content-menu col-sm-9" id="profile-content">
    <div class="menu-tabs">
        <button tablink="Balance" class="tablinks active" onclick="openTab(event, 'Balance')" id="defaultOpen">Balance</button>
        <button tablink="Withdraw" class="tablinks" onclick="openTab(event, 'Withdraw')">Withdraw</button>
    </div>

    <div class="tab-content-bg">
        <div class="tabcontent" id="Balance">
            @if (Session::has('payment-success'))
            <div class="alert alert-success" role="alert">
               Payment was successfully processed! Thank you!
            </div>
            @endif
            @if (Session::has('payment-success-mollie'))
            <div class="alert alert-success" role="alert">
               Payment was successfully processed! If the funds aren't added please allow up to 24 hours.
            </div>
            @endif
            @if (Session::has('payment-error'))
            <div class="alert alert-danger" role="alert">
               Payment canceled by you or there was a problem. If the problem persists please contact an Admin via Discord.
            </div>
            @endif
            @if (Session::has('already-req'))
            <div class="alert alert-danger" role="alert">
               You have already requested for a cashout. Please let it be completed or denied first!
            </div>
            @endif
            @if (Session::has('no-funds'))
            <div class="alert alert-danger" role="alert">
               You have not enough funds for this cashout request!
            </div>
            @endif
            <div class="balance-left col-sm-6">
                <div class="bg-light tot-bal">
                    <div class="col-sm-8">
                        Your Balance:
                    </div>
                    <div class="col-sm-4" style="text-align: right;">
                        {{auth()->user()->wallet->getBalance()}}$
                    </div>
                </div>
                <div class="bg-light bal-others">
                    <div class="col-sm-8">
                        Cash from added funds:
                    </div>
                    <div class="col-sm-4" style="text-align: right;">
                        {{number_format($amounts['added'], 2, ',', '.')}}$
                    </div>
                </div>
                <div class="bg-light bal-others">
                    <div class="col-sm-8">
                        Cash earned through referrals:
                    </div>
                    <div class="col-sm-4" style="text-align: right;">
                        {{number_format($amounts['referrals'], 2, ',', '.')}}$
                    </div>
                </div>
                @if(auth()->user()->hasRole('Contributor'))
                <div class="bg-light bal-others">
                    <div class="col-sm-8">
                        Cash earned through discount code:
                    </div>
                    <div class="col-sm-4" style="text-align: right;">
                        {{number_format($amounts['dcode'], 2, ',', '.')}}$
                    </div>
                </div>
                <div class="bg-light bal-others">
                    <div class="col-sm-8">
                        Cash earned through items:
                    </div>
                    <div class="col-sm-4" style="text-align: right;">
                        {{number_format($amounts['items'], 2, ',', '.')}}$
                    </div>
                </div>
                @endif
                <div class="bg-light bal-others">
                    <div class="col-sm-8">
                        Credit granted:
                    </div>
                    <div class="col-sm-4" style="text-align: right;">
                        {{number_format($amounts['credit'], 2, ',', '.')}}$
                    </div>
                </div>
            </div>
            <div class="balance-right col-sm-6 bg-light">
                <div class="add-funds">
                    Add Funds
                </div>
                <form class="" action="{{route('wallet.deposit')}}" method="post">
                    @csrf
                    <div class="custom-radios">
                        <input type="radio" class="custom_radio" name="amount" value="5" id="5usd" checked/><label for="5usd">5 $</label>
                        <input type="radio" class="custom_radio" name="amount" value="10" id="10usd"/><label for="10usd">10 $</label>
                        <input type="radio" class="custom_radio" name="amount" value="25" id="25usd"/><label for="25usd">25 $</label>
                        <input type="radio" class="custom_radio" name="amount" value="50" id="50usd"/><label for="50usd">50 $</label>
                        <input type="radio" class="custom_radio" name="amount" value="100" id="100usd"/><label for="100usd">100 $</label>
                        <input type="radio" class="custom_radio" name="amount" value="250" id="250usd"/><label for="250usd">250 $</label>
                        <input type="radio" class="custom_radio" name="amount" value="500" id="500usd"/><label for="500usd">500 $</label>
                        <input type="radio" class="custom_radio" name="amount" value="1000" id="1000usd"/><label for="1000usd">1000 $</label>
                    </div>
                    <div class="custom-select">
                        <label>Payment Method</label>
                        <label for="custom-select" class="custom-sel">
                            <select id="custom-select" class="custom-payment-method" name="payment-method">
                                <option value="PayPal">PayPal</option>
                                <option value="paysafecard">paysafecard</option>
                                <option value="creditcard">Credit Card</option>
                                <option value="ideal">iDeal</option>
                                <option value="sofort">Sofort</option>
                                <option value="giropay">GiroPay</option>
                            </select>
                        </label>
                    </div>
                    <br>
                    <div class="form-check form-check-inline pull-left">
                        <input class="form-check-input required-checkbox" type="checkbox" id="checkouttermsconditions" name="termsandconditons" required><label class="form-check-label" for="checkouttermsconditions">I have read and agree to the <a href="{{route('legal.toc')}}" target="_blank"><strong>Terms &amp; Conditions</strong></a> and the <a href="{{route('legal.privacy')}}" target="_blank"><strong>Privacy Policy</strong></a>.
                        </label>
                        <p class="form-check-label">By clicking on "Checkout" I'm agreeing to execute the contract begin before the end
                        of the withdrawal period. With execution of the contract I'm losing my <a href="{{route('legal.row')}}" target="_blank"><strong>right of withdrawal</strong></a>.</p>
                        <button type="submit" class="btn-primary btn-block btn-lg">Checkout</button>
                        <p class="form-check-label" style="font-size: 12px;">Pay securely thanks to our 256-bit SSL connection.</p>
                    </div>
                </form>
            </div>
        </div>
        <div class="tabcontent" id="Withdraw">
            <div class="bg-light">
                Available cash for withdrawal: <b>{{number_format(auth()->user()->wallet->getCashoutAmount(), 2, ',', '.')}}</b> $
                <form action="{{route('cashout.request')}}" method="post">
                    @csrf
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label class="sr-only" for="amountinput">Amount (in dollars)</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fas fa-wallet"></i></div>
                                <input type="text" name="amount" placeholder="Amount" id="amountinput" class="form-control" required>
                                <div class="input-group-addon">$</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="paypalinput">PayPal Email</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fab fa-paypal"></i></div>
                                <input type="email" name="paypal" placeholder="PayPal E-Mail Address" id="paypalinput" class="form-control" required>
                                <div class="input-group-addon">@</div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Confirm Withdrawal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
