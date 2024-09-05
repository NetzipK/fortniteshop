@extends('layouts.shop')

@section('siteTitle')
Privacy Policy
@endsection
@section('seo')
<meta name="description" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<meta name="og:title" property="og:title" content="Buy amazing Fortnite - Save the World items at fortnitemall.gg.">
<link href="{{Request::url()}}" rel="canonical">
@endsection

@section('content')
<section class="breadcrumb-wrapper" style="margin-top: -50px;">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="index.html">Home</a></li>
                    <li class="active">Cookie Policy</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content eshop">
    <div class="container">
        <article class="default-style">

            <h1>Right of withdrawal</h1>
            <p>You have the right to withdraw from this contract within 14 days without giving any reason.</p>

            <p>The withdrawal period will expire after 14 days from the day on which you acquire, or a third party other than the carrier and indicated by you, acquires, digital possession of the goods.</p>

            <p>To exercise the right of withdrawal, you must inform us (MID Gaming OÜ, Veerise tn 14-3, Haabersti linnaosa, Tallinn, 13516 Harju maakond, Estonia, support@fortnitemall.gg, Livechat on our website) of your decision to withdraw from this contract by an unequivocal statement (e.g. a letter sent by post, application via livechat or e-mail).</p>

            <p>To meet the withdrawal deadline, it is sufficient for you to send your communication concerning your exercise of the right of withdrawal before the withdrawal period has expired.</p>

            <p><strong>Effects of withdrawal</strong></p>
            <p>If you withdraw from this contract, we shall reimburse to you all payments received from you, for the products, without undue delay and in any event not later than 14 days from the day on which we are informed about your decision to withdraw from this contract.
            </br>We will carry out such reimbursement using the same means of payment as you used for the initial transaction, unless you have expressly agreed otherwise; in any event, you will not incur any fees as a result of such reimbursement.</p>
            <p>Please note that refunds can take up to 1 week to complete. Orders made with paysafecard as payment method cannot be refunded.</p>
        </article>
    </div>
</section>
@endsection
