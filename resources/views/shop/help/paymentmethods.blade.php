@extends('shop.help.layout')

@section('help-content')

<div class="pMethods" id="helpcontent">
    <ul>
        <li>
            <div class="pMethodImg">
                <img src="{{URL::to('/')}}/assets/images/cart/paypal-logo.png" alt="PayPal Logo">
            </div>
            <div class="pMethodContent">
                <h4>PayPal</h4>
                <p>
                    PayPal is a service that enables you to pay, send money, and accept payments.
                    Register your credit card or debit card with your PayPal account.
                    You can pay by simply choosing PayPal at checkout, logging into your PayPal account, and confirming your payment.
                </p>
            </div>
        </li>
        <li>
            <div class="pMethodImg">
                <img src="{{URL::to('/')}}/assets/images/cart/paysafecard-logo.png" alt="paysafecard Logo">
            </div>
            <div class="pMethodContent">
                <h4>paysafecard</h4>
                <p>
                    Paysafecard is a prepaid online payment method based on vouchers with a 16-digit PIN code, independent of bank account, credit card, or other personal information.
                    Customers can purchase vouchers at local sales outlets and pay online by entering the code at the checkout of our website.
                </p>
            </div>
        </li>
        <li>
            <div class="pMethodImg">
                <img src="{{URL::to('/')}}/assets/images/cart/creditcard-logo.png" alt="Credit Card Logo">
            </div>
            <div class="pMethodContent">
                <h4>Credit Card</h4>
                <p>
                    You can pay on our shop using your credit card.
                    This is possible thanks to our partners Mollie.
                    We do not collect any of your data in any way, since we have no access to see anything you type in after clicking on CHECKOUT.
                    Payments are not always instant, but 100% safe.
                </p>
            </div>
        </li>
        <li>
            <div class="pMethodImg">
                <img src="{{URL::to('/')}}/assets/images/cart/ideal-logo.png" alt="iDEAL Logo">
            </div>
            <div class="pMethodContent">
                <h4>iDEAL</h4>
                <p>
                    iDEAL is an e-commerce payment system used in the Netherlands, based on online banking.
                    This payment method allows customers to buy on the Internet using direct online transfers from their bank account.
                    Payments are not always instant, but 100% safe.
                </p>
            </div>
        </li>
        <li>
            <div class="pMethodImg">
                <img src="{{URL::to('/')}}/assets/images/cart/sofort-logo.png" alt="Sofort Logo">
            </div>
            <div class="pMethodContent">
                <h4>Sofort</h4>
                <p>
                    SOFORT is an online direct payment method and works on the basis of online banking.
                    The big advantage is: You don’t need to register or open a virtual account, known as a wallet. It is an immediate and direct transfer of funds.
                    Customers who select SOFORT as their preferred method of payment for an online purchase will be directed straight to the secure sofort.com payment form.
                </p>
            </div>
        </li>
        <li>
            <div class="pMethodImg">
                <img src="{{URL::to('/')}}/assets/images/cart/giropay-logo.png" alt="GiroPay Logo">
            </div>
            <div class="pMethodContent">
                <h4>Giropay</h4>
                <p>
                    Germany’s most popular way to pay online is the bank transfer, used in 51% of all online purchases.
                    This makes Giropay, integrating over 1,500 German banks, a very popular payment method on the German market.
                    Because it uses real-time bank transfer, the payments made with Giropay are 100% guaranteed.
                </p>
            </div>
        </li>
        <li>
            <div class="pMethodImg">
                <img src="{{URL::to('/')}}/assets/images/cart/apple-pay-logo.png" alt="ApplePay Logo">
            </div>
            <div class="pMethodContent">
                <h4>Apple Pay</h4>
                <p>
                    Apple Pay is a contactless payment technology for Apple devices.
                    It was designed to move consumers away from physical wallets into a world where your debit and credit cards are on your iPhone, allowing you to pay using your device instead of a card.
                    Please note that you need to be using the website on an Apple device to view this payment method.
                </p>
            </div>
        </li>
    </ul>
</div>

@endsection
