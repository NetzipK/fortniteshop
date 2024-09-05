<div class="row">
    <div class="col-sm-12" id="shopping-cart">
        @if (Session::has('article-updated'))
        <div class="alert alert-info" role="alert">
            Your Fortnitemall article was successfully updated.
        </div>
        @endif
        @if (Session::has('article-deleted'))
        <div class="alert alert-info" role="alert">
            The Fortnitemall article was successfully removed from your Shopping Cart.
        </div>
        @endif
        @if (Session::has('coupon-applied'))
        <div class="alert alert-success" role="alert">
           Your coupon was successfully applied.
        </div>
        @endif
        @if (Session::has('coupon-error'))
        <div class="alert alert-danger" role="alert">
           Your coupon is invalid or already used. Please try another one.
        </div>
        @endif
        @if (Session::has('coupon-removed'))
        <div class="alert alert-info" role="alert">
           Your coupon was successfully removed.
        </div>
        @endif
        @if (Session::has('insufficient-funds'))
        <div class="alert alert-danger" role="alert">
           Insufficient funds on your wallet. Add funds or use different payment method.
        </div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(Cart::count() > 0)
        <article class="account-content">
            <div class="checkout-step">
                <label class="number">1</label>
                <span class="title">Your order</span>
            </div>
            <div class="products-order shopping-cart">
                <div class="table-responsive">
                    <table class="table table-products">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Article name</th>
                                <th>Price per unit</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Cart::content() as $article)
                            <tr id="shoppingcart-article-{{$article->id}}">
                                <td class="col-xs-1"><img src="{{route('article.image', $article->model->image_name)}}" alt="Fortnitemall.gg article Shopping Cart | {{$article->model->name }}" class="img-responsive"></td>
                                @if(class_basename($article->model) === "Article")
                                <td class="col-xs-3">
                                    <h4>
                                        <a href="single-product.html">
                                            {{$article->model->amount_step_size}}x {{$article->model->name}}
                                        </a>
                                        <small>The total amount is {{$article->model->amount_step_size * $article->qty}}</small>
                                    </h4>
                                </td>
                                <td class="col-xs-2 text-center"><span>USD {{number_format($article->price, 2)}}</span></td>
                                <td class="col-xs-2 col-md-1">
                                    <div class="form-group">
                                        <form id="update-quantity-{{$article->model->external_id}}" action="{{ route('cart.update', $article->model->external_id) }}" method="POST">
                                            @csrf
                                            <input
                                                type="number" id="quantity" name="quantity"
                                                min="1"
                                                data-article-id="{{$article->id}}" class="form-control quantity-changer"
                                                value="{{$article->qty}}"
                                                onblur="event.preventDefault(); document.getElementById('update-quantity-{{$article->model->external_id}}').submit();">
                                        </form>
                                    </div>
                                </td>
                                <td class="col-xs-2 text-center"><span><b>USD {{number_format($article->total,2)}}</b></span></td>
                                <td class="col-xs-1 text-center">
                                    <form id="delete-quantity-{{$article->model->external_id}}" action="{{ route('cart.delete', $article->model->external_id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <button class="btn btn-danger delete-article" data-article-id="{{$article->id}}" onclick="event.preventDefault(); document.getElementById('delete-quantity-{{$article->model->external_id}}').submit();">
                                        <i id="shoppingcart-delete-{{$article->id}}" class="fa fa-times"></i>
                                    </button>
                                </td>
                                @else
                                <td class="col-xs-3">
                                    <h4>
                                        <a href="single-product.html">
                                            1x {{$article->model->name}}
                                        </a>
                                    </h4>
                                </td>
                                <td class="col-xs-2 text-center"><span>USD {{number_format($article->price, 2)}}</span></td>
                                <td class="col-xs-2 col-md-1">

                                </td>
                                <td class="col-xs-2 text-center"><span><b>USD {{number_format($article->total,2)}}</b></span></td>
                                <td class="col-xs-1 text-center">
                                    <form id="delete-quantity-{{$article->model->external_id}}" action="{{ route('cart.delete', $article->model->external_id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <button class="btn btn-danger delete-article" data-article-id="{{$article->id}}" onclick="event.preventDefault(); document.getElementById('delete-quantity-{{$article->model->external_id}}').submit();">
                                        <i id="shoppingcart-delete-{{$article->id}}" class="fa fa-times"></i>
                                    </button>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <a href="{{route('shop.index')}}" class="btn btn-inverse">Continue Shopping</a>
                <div style="margin-top: -32px;">
                    <ul class="list-unstyled order-total">
                        <li>Subtotal<span> USD {{Cart::subtotal()}}</span></li>
                    </ul>
                </div>
            </div>
            <div class="warning-box">
                <img class="hidden-xs" src="{{URL::to('/')}}/assets/images/others/raptor_spidey.png">
                <div class="background-box">
                    <i class="fa fa-exclamation-circle" style="color: #dbab00; font-size: 32px;"></i> We are <span>NOT</span> possible to add you on XBOX or PS4. Please make sure that you fill in your EPIC Name correctly!
                </div>
            </div>

        </article>
    </div>
</div>
@if((session('coupon') && $total >= 3.49) || !session('coupon') && $total >= 3.49)
<form name="checkoutForm" id="checkout-form" action="{{route('checkout.paypal.create')}}" method="POST">
<div class="row">
    <div class="col-sm-12">
        <article class="account-content" style="margin-top: 15px;">
            <div class="checkout-step">
                <label class="number">2</label>
                <span class="title">Please fill in the following information about yourself</span>
            </div>
            @csrf
            <div class="box" style="padding-bottom: 5px;">
                <div class="row">
                    {{-- Email --}}
                    <div class="form-group col-sm-3">
                        <label>Your Epic Games E-mail address<span class="required">*</span> <div class="cart-tooltip"><i class="fas fa-question-circle"></i> <span class="cart-tooltiptext">You need to fill in your Epic Games login email, not XBOX/PSN login.</span> </div></label>
                        @auth
                        <input type="email" id="email" name="email" value="{{Auth::user()->email}}" class="form-control required-field" required>
                        @endauth
                        @guest
                        <input type="email" id="email" name="email" class="form-control required-field" value="{{old('email')}}" required>
                        @endguest
                    </div>
                </div>
                <div class="row">
                    {{-- Platform --}}
                    <div class="form-group col-sm-8 col-lg-4">
                        <label>Select Platform<span class="required">*</span></label>
                        <div class="platforms-radio">
                            {{--<option @if(isset(Auth::user()->platform) && Auth::user()->platform === 'PC') selected @endif>PC</option>
                            <option @if(isset(Auth::user()->platform) && Auth::user()->platform === 'PS4') selected @endif>PS4</option>
                            <option @if(isset(Auth::user()->platform) && Auth::user()->platform === 'XBOX') selected @endif>XBOX</option> --}}
                            <input type="radio" class="custom_radio" name="platform" value="PC" id="PC" @if((isset(Auth::user()->platform) && Auth::user()->platform === 'PC') || Auth::guest()) checked @endif /><label for="PC"> <img src="{{URL::to('/')}}/assets/images/others/windows.png" alt="PC"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                            <input type="radio" class="custom_radio" name="platform" value="PS4" id="PS4" @if(isset(Auth::user()->platform) && Auth::user()->platform === 'PS4') checked @endif/><label for="PS4"> <img src="{{URL::to('/')}}/assets/images/others/ps4.png" alt="PS4"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                            <input type="radio" class="custom_radio" name="platform" value="XBOX" id="XBOX" @if(isset(Auth::user()->platform) && Auth::user()->platform === 'XBOX') checked @endif/><label for="XBOX"> <img src="{{URL::to('/')}}/assets/images/others/xbox.png" alt="XBOX"> <img src="{{URL::to('/')}}/assets/images/others/check.png" alt="" class="platform_checked"> </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    {{-- Epic Id --}}
                    <div class="form-group col-sm-3">
                        <label>Your Epic Name (Fortnite Name)<span class="required">*</span> <div class="cart-tooltip hide-when-pc"><i class="fas fa-question-circle"></i> <span class="cart-tooltiptext">You need to fill in your Epic Games name, not your XBOX Gamertag or PSN-ID. If you play on multiple platforms fill in your other names into the therefore intended textboxes.<br>
                            <br>If you are playing on XBox or PS4 your account needs to be linked with Epic Games.<br><br><a href="https://epicgames.helpshift.com/a/fortnite/?s=general&f=how-do-i-connect-link-my-console-account-to-my-epic-account" target="_blank">Learn more</a></span> </div></label>
                        @auth
                        <input type="text" id="epic_id" name="epic_id" value="{{Auth::user()->epic_id}}" class="form-control required-field" required>
                        @endauth
                        @guest
                        <input type="text" id="epic_id" name="epic_id" class="form-control required-field" value="{{old('epic_id')}}" required>
                        @endguest
                        <a href="{{route('guides.findYourEpicId')}}" style="font-size: 11px; margin-top: 0;" class="label label-info">How to find your Epic Name</a>
                    </div>
                    <div class="form-group col-sm-3 platform-username-div" style="display: none;">
                        <label id="platform_username_label">PlayStation Nickname<span class="required">(optional)</span></label>
                        <input type="text" id="platform_username" name="platform_username" class="form-control">
                    </div>
                </div>
                <div class="row">
                    {{-- Discord --}}
                    <div class="form-group col-sm-3">
                        <label>Discord Name<span class="required">(optional)</span></label>
                        @auth
                        <input type="text" id="discord_id" name="discord_id" value="{{Auth::user()->discord_id}}" placeholder="nickname#1234" class="form-control" pattern="\w+#\d{4}" oninput="setCustomValidity('')" oninvalid="setCustomValidity('Please use the correct Discord username format. Example: Username#0000 ');">
                        @endauth
                        @guest
                        <input type="text" id="discord_id" name="discord_id" placeholder="nickname#1234" value="{{old('discord_id')}}" class="form-control" pattern="\w+#\d{4}" oninput="setCustomValidity('')" oninvalid="setCustomValidity('Please use the correct Discord username format. Example: Username#0000 ');">
                        @endguest
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <article class="account-content" style="margin-top: 15px;">
            <div class="checkout-step">
                <label class="number">3</label>
                <span class="title">Choose your payment method</span>
            </div>
            <div class="box">
                <div class="row">
                    <div class="col-sm-6">
                        @if(session('coupon'))
                        <div>Your applied coupon <span class="label label-info">{{session('coupon')['name']}}</span> is active</div>
                        <button class="btn btn-danger btn-sm" type="submit" form="coupon-form" style="margin-top: 10px;">Remove Coupon</button>
                        @else
                        <h5>Enter your coupon code if you have one.</h5>
                            <div class="input-group">
                                <input type="text" name="code" class="form-control" placeholder="Discount code" form="coupon-form">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit" form="coupon-form">Apply Coupon</button>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="col-sm-4 col-sm-offset-2">
                        <ul class="list-unstyled order-total">
                            <li>Subtotal <span>USD {{Cart::subtotal()}}</span></li>
                            @if(session('coupon'))
                                <li>Discount<span>- USD {{ number_format($discount, 2, ",", ".")}}</span></li>
                                @auth
                                <li>Loyalty Bonus<span>- USD {{ number_format($loyaltyBonus, 2, ",", ".")}}</span></li>
                                @endauth
                                <li style="font-size: 18px;">Total<span class="total">USD {{ number_format($total, 2, ',', '.')}}</span></li>
                            @else
                                @auth
                                <li>Loyalty Bonus<span>- USD {{ number_format($loyaltyBonus, 2, ",", ".")}}</span></li>
                                @endauth
                                <li style="font-size: 18px;">Total<span class="total">USD {{ number_format($total, 2, ',', '.')}}</span></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix">
                <div class="form-check form-check-inline pull-left">
                    <input id="checkbox-1" class="form-check-input required-checkbox" type="checkbox" id="correct-epic-id" name="correctepicid" required>
                    <label class="form-check-label" for="correct-epic-id">I have filled in my EPIC Name correctly, otherwise FortniteShop may not be able to deliver the goods. *</label>
                    <br>
                    <input id="checkbox-2" class="form-check-input required-checkbox" type="checkbox" id="checkouttermsconditions" name="termsandconditons" required>
                    <label class="form-check-label" for="termsconditions">I have read and agree to the <a href="{{route('legal.toc')}}" target="_blank"><strong>Terms &amp; Conditions</strong></a> and the <a href="{{route('legal.privacy')}}" target="_blank"><strong>Privacy Policy</strong></a>.</label>
                    <p class="form-check-label">By clicking on "Checkout" I'm agreeing to execute the contract begin before the end
                    of the withdrawal period. With execution of the contract I'm losing my <a href="{{route('legal.row')}}" target="_blank"><strong>right of withdrawal</strong></a>.</p>
                    <p class="form-check-label">Pay securely thanks to our 256-bit SSL connection.</p>
                </div>
            </div>
            <div class="box">
                <div class="row">
                    <div class="col-sm-12 col-lg-4">
                        <input type="radio" class="custom_radio_payment" name="payment_method" value="PayPal" id="PayPal" checked><label for="PayPal"><img src="{{URL::to('/')}}/assets/images/others/Paypal-Logo-2015.png" alt=""> </label>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <input type="radio" class="custom_radio_payment" name="payment_method" value="paysafecard" id="paysafecard"><label for="paysafecard" ><img src="{{URL::to('/')}}/assets/images/others/paysafecard-logo.jpg" alt=""> <span style="position: absolute; font-size: 10px; top: 45px; right: 10px; color: #E74C3C; font-weight: 400;">(fee: +8,00%)</span> </label>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <input type="radio" class="custom_radio_payment" name="payment_method" value="creditcard" id="creditcard"><label for="creditcard" ><img src="{{URL::to('/')}}/assets/images/others/paysafecard-logo.jpg" alt=""> <span style="position: absolute; font-size: 10px; top: 45px; right: 10px; color: #E74C3C; font-weight: 400;">(fee: +8,00%)</span> </label>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <input type="radio" class="custom_radio_payment" name="payment_method" value="ideal" id="ideal"><label for="ideal" ><img src="{{URL::to('/')}}/assets/images/others/paysafecard-logo.jpg" alt=""> <span style="position: absolute; font-size: 10px; top: 45px; right: 10px; color: #E74C3C; font-weight: 400;">(fee: +8,00%)</span> </label>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <input type="radio" class="custom_radio_payment" name="payment_method" value="sofort" id="sofort"><label for="sofort" ><img src="{{URL::to('/')}}/assets/images/others/paysafecard-logo.jpg" alt=""> <span style="position: absolute; font-size: 10px; top: 45px; right: 10px; color: #E74C3C; font-weight: 400;">(fee: +8,00%)</span> </label>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <input type="radio" class="custom_radio_payment" name="payment_method" value="giropay" id="giropay"><label for="giropay" ><img src="{{URL::to('/')}}/assets/images/others/paysafecard-logo.jpg" alt=""> <span style="position: absolute; font-size: 10px; top: 45px; right: 10px; color: #E74C3C; font-weight: 400;">(fee: +8,00%)</span> </label>
                    </div>
                    <div class="col-sm-12 col-lg-4 apple-pay-check">
                        <input type="radio" class="custom_radio_payment" name="payment_method" value="applepay" id="applepay"><label for="applepay" ><img src="{{URL::to('/')}}/assets/images/cart/apple-pay-logo.png" alt=""> </label>
                    </div>
                    <div class="col-sm-12 col-lg-4 apple-pay-check">
                        <input type="radio" class="custom_radio_payment" name="payment_method" value="wallet" id="wallet"><label for="wallet" ><img src="{{URL::to('/')}}/assets/images/cart/apple-pay-logo.png" alt=""> </label>
                    </div>
                </div>
            </div>
                <div class="cart-button">
                    <button id="checkout-paypal" type="submit"class="btn btn-danger btn-lg checkout-button" disabled> <i class="fas fa-wallet"></i> Checkout</button>
                </div>
                <button id="checkout-paysafecard" type="submit"class="btn btn-danger btn-lg pull-right" style="margin-right: 2px; display:none;" disabled>Checkout with paysafecard <img href="https://www.paysafecard.com/fileadmin/Website/Dokumente/B2B/logo_paysafecard.jpg" style="width: 50%;"></img></button>
                <div data-id="VPK-TviPD0W" class="warning-message">
                    *In case you filled in your EPIC Name wrongly, please get in contact with us using this link: <a data-id="VPK-TviPD0W" class="livechat_button" href="https://www.chatbot.com/?utm_source=chat_button&utm_medium=referral&utm_campaign=lc_10807857">LiveChat</a> or <a href="https://discordapp.com/invite/YuutkQy" target="_blank">Discord</a>.
                </div>
        </article>
    </div>
</div>
</form>
@if(session('coupon'))
<form id="coupon-form" action="{{route('cart.coupon.delete')}}" method="POST">
    @csrf
</form>
@else
<form id="coupon-form" action="{{route('cart.coupon.add')}}" method="POST">
    @csrf
</form>
@endif
@else
<div class="row">
    <div class="col-sm-12">
        <article class="account-content" style="margin-top: 15px;">
            <div class="row" style="display: flex;">
                <div class="col-md-offset-2 col-md-6" style="align-self: center;">
                    <hp style="font-size: 2rem;"></hp>
                    <!-- <p style="font-size: 2.25rem;">The minimum amount for your order is <strong>at least USD 1.50</strong>. Please add something to your card.</p> -->
                    <p style="font-size: 2.25rem;">Due to increased amount of purchases, the minimum amount for your order is <strong>at least USD 3,49</strong>. Please add something to your cart.</p>
                    <a href="{{route('shop.index')}}" class="btn btn-danger">Visit our Fortnitemall</a>
                </div>
                <div class="col-md-3">
                    <img src="{{URL::to('/')}}/assets/images/fortnite/fortnite-skins-png-17.png" alt="Fortnite Shop Empty Cart Bus" class="img-responsive">
                </div>
            </div>
        </article>
    </div>
</div>
@endif
@else
<div class="row">
    <div class="col-sm-12">
        <article class="account-content" style="margin-top: 15px;">
            <div class="row" style="display: flex;">
                <div class="col-md-offset-2 col-md-6" style="align-self: center;">
                    <hp style="font-size: 2rem;">Your cart is currently empty.</hp>
                    <p style="font-size: 1.75rem;">Make sure to add something from our amazing Fortnite item shop.</p>
                    <a href="{{route('shop.index')}}" class="btn btn-danger">Visit our Fortnitemall</a>
                </div>
                <div class="col-md-3">
                    <img src="{{URL::to('/')}}/assets/images/fortnite/fortnite-skins-png-17.png" alt="Fortnite Shop Empty Cart Bus" class="img-responsive">
                </div>
            </div>
</article>
</div>
</div>

@endif
<script>
    $(document).ready(function() {
        $('.required-checkbox').on('click', function() {
            if (validateCheckbox() === true) {
                $('#checkout-paypal').prop("disabled", false);
            } else {
                $('#checkout-paypal').prop("disabled", true);
            }
        });
        $('#checkout-paypal').on('click', function() {
            if (validateForm() === true && validateDiscord() === true) {
                $(this).prop("disabled", true);
                $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                if($('#PayPal').is(":checked")) {
                    $('#checkout-form').submit();
                }
                if($('#paysafecard').is(":checked")) {
                    document.checkoutForm.action = "{{route('checkout.paysafecard.create')}}"
                    $('#checkout-form').submit();
                }
                if($('#creditcard').is(":checked")) {
                    document.checkoutForm.action = "{{route('checkout.mollie.create')}}"
                    $('#checkout-form').submit();
                }
                if($('#ideal').is(":checked")) {
                    document.checkoutForm.action = "{{route('checkout.mollie.create')}}"
                    $('#checkout-form').submit();
                }
                if($('#sofort').is(":checked")) {
                    document.checkoutForm.action = "{{route('checkout.mollie.create')}}"
                    $('#checkout-form').submit();
                }
                if($('#giropay').is(":checked")) {
                    document.checkoutForm.action = "{{route('checkout.mollie.create')}}"
                    $('#checkout-form').submit();
                }
                if($('#applepay').is(":checked")) {
                    document.checkoutForm.action = "{{route('checkout.mollie.create')}}"
                    $('#checkout-form').submit();
                }
                if($('#wallet').is(":checked")) {
                    document.checkoutForm.action = "{{route('checkout.wallet.create')}}"
                    $('#checkout-form').submit();
                }
            }
        });

        $('#checkout-paysafecard').on('click', function() {
            if (validateForm() === true && validateDiscord() === true) {
                $(this).prop("disabled", true);
                $(this).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                document.checkoutForm.action = "{{route('checkout.paysafecard.create')}}"
                $('#checkout-form').submit();
            }
        });
        $('input[name=platform]').on('click', function() {
            setPlatformField();
        });
        $('input[name=payment_method]').on('click', function() {
            showPSCFee();
        });

        if(!window.ApplePaySession || !ApplePaySession.canMakePayments()) {
            $('.apple-pay-check').show();
        } else {
            $('.apple-pay-check').hide();
        }

        setPlatformField();
        showPSCFee();
    });
    function validateForm() {
        var isValid = true;
        $('.required-field').each(function() {
            if ($(this).val() === '')
            isValid = false;
        });
        return isValid;
    }

    function validateCheckbox() {
        var isValid = false;
        if ($(".required-checkbox").length === $(".required-checkbox:checked").length) {
            isValid = true;
        }
        return isValid;
    }

    function validateDiscord() {
        var isDiscordValid = true;
        const input = $("input[name=discord_id]");
        var pattern = RegExp(input.attr("pattern"));
        isDiscordValid = pattern.test(input.val());
        if(input.val() === '')
            isDiscordValid = true;
        return isDiscordValid;
    }

    function setPlatformField() {
        var platformCheckbox = $('input[name=platform]:checked').val();
        if (platformCheckbox === "PC") {
            $('.platform-username-div').css('display', 'none');
            $('.hide-when-pc').hide();
        }
        if (platformCheckbox === "PS4") {
            $('.platform-username-div').css('display', '');
            $('#platform_username_label').html('Your PSN ID<span class="required">(optional)</span>');
            $('.hide-when-pc').show();
        }
        if (platformCheckbox === "XBOX") {
            $('.platform-username-div').css('display', '');
            $('#platform_username_label').html('Your XBOX Gamertag<span class="required">(optional)</span>');
            $('.hide-when-pc').show();
        }
    }

    function showPSCFee() {
        if($('#paysafecard').is(":checked")) {
            $('.total').html('USD {{number_format($total + $total * 8/100, 2, ',', '.')}}');
        }
        else {
            $('.total').html('USD {{number_format($total, 2, ',', '.')}}');
        }
    }

</script>
