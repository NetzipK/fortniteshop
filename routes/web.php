<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('shop.home');

/** Authentication */
Auth::routes();

/** Shopping cart */
Route::prefix('cart')->group(function () {
    Route::get('/', 'CartController@index')->name('cart.index');
    Route::post('/add/{articleExternalId}', 'CartController@addArticle')->name('cart.add');
    Route::post('/quantity/{articleExternalId}', 'CartController@updateArticle')->name('cart.update');
    Route::post('/remove/{articleId}', 'CartController@removeArticle')->name('cart.delete');
    Route::post('/coupon/add', 'DiscountCodeController@addDCToCart')->name('cart.coupon.add');
    Route::post('/coupon/remove', 'DiscountCodeController@removeDCFromCart')->name('cart.coupon.delete');
});

/** Legal sites */
Route::prefix('legal')->group(function () {
    Route::get('/privacy-policy', 'HomeController@privacy')->name('legal.privacy');
    Route::get('/terms-and-conditions', 'HomeController@toc')->name('legal.toc');
    Route::get('/cookie-policy', 'HomeController@cookie')->name('legal.cookie');
    Route::get('/accept-cookies', function() {
        $response = new Illuminate\Http\Response('Hello World');
        $response->withCookie(cookie('cookies-accepted', true, 57600));
        return $response;
    });
    Route::get('/right-of-withdrawal', 'HomeController@row')->name('legal.row');
});

/** Shop routes */
Route::prefix('shop/articles')->group(function () {
    Route::get('/', 'ArticleController@index')->name('shop.index');
    Route::get('/search', 'ArticleController@search')->name('shop.search');
    Route::get('/category/{categoryId}', 'ArticleController@category')->name('shop.category');
    Route::get('/{articleExternalId}', 'ArticleController@show')->name('article.show');
    Route::get('/image/{imageName}', 'ArticleController@getArticleWatermarkImage')->name('article.image');
});

/* Account Routes */
Route::prefix('shop/accounts')->group(function () {
    Route::get('/', 'AccountController@index')->name('accounts.index');
    Route::get('/stw', 'AccountController@ShowSTW')->name('accounts.showstw');
    Route::get('/br', 'AccountController@ShowBR')->name('accounts.showbr');
    Route::get('/{accountExternalId}', 'AccountController@show')->name('account.show');
    Route::post('/brfilter', 'AccountController@filterAccountsBR');
    Route::post('/stwfilter', 'AccountController@filterAccountsSTW');

    //Route::get('/test', 'AccountController@indexTest')->name('accounts.test');
});

Route::get('/testOutfit/{imageName}', 'AccountController@testOutfit')->name('test.outfit');

Route::get('/test', 'AccountController@indexTest')->name('accounts.test');
Route::post('/accounts', 'AccountController@postAccounts');

Route::get('/paysafe', 'CheckoutController@indexTest')->name('paysafe.test');

/* Skin Routes */
Route::prefix('shop/skins')->group(function () {
    Route::get('/', 'SkinController@index')->name('skins.index');
    Route::get('/{skinExternalId}', 'SkinController@show')->name('skin.show');
    Route::get('/image/{imageName}', 'SkinController@getSkinWatermarkImage')->name('skin.image');
    Route::post('/skinfilter', 'SkinController@filterSkins');
});

/** Checkout routes */
Route::prefix('checkout')->group(function () {
    /* PAYPAL */
    Route::post('/paypal', 'CheckoutController@createPaypalOrder')->name('checkout.paypal.create');
    Route::get('/paypal/success/{invoice_id}/{order_pin}', 'CheckoutController@paypalPaymentSuccessAndPay')->name('checkout.paypal.success');
    Route::get('/paypal/invoice/{invoice_id}/{order_pin}', 'CheckoutController@paypalPaymentShowInvoicePage')->name('checkout.paypal.invoice');
    Route::get('/paypal/error', 'CheckoutController@paypalPaymentError')->name('checkout.paypal.error');

    /* PAYSAFECARD */
    Route::post('/paysafecard', 'CheckoutController@createPaysafecardOrder')->name('checkout.paysafecard.create');
    Route::get('/paysafecard/success/{invoice_id}/{order_pin}', 'CheckoutController@paysafecardPaymentSuccessAndPay')->name('checkout.paysafecard.success');
    Route::post('/paysafecard/notification/{invoice_id}', 'CheckoutController@paysafecardNotification')->name('checkout.paysafecard.notification');
    Route::get('/paysafecard/invoice/{invoice_id}/{order_pin}', 'CheckoutController@paysafecardPaymentShowInvoicePage')->name('checkout.paysafecard.invoice');
    Route::get('/paysafecard/error', 'CheckoutController@paysafecardPaymentError')->name('checkout.paysafecard.error');

    /* MOLLIE */
    Route::post('/mollie', 'CheckoutController@createMollieOrder')->name('checkout.mollie.create');
    Route::get('/mollie/invoice/{invoice_id}/{order_pin}', 'CheckoutController@molliePaymentShowInvoicePage')->name('checkout.mollie.invoice');
    Route::post('/mollie/webhook/{invoice_id}', 'CheckoutController@mollieNotification')->name('checkout.mollie.notification');

    /* WALLET */
    Route::post('/wallet', 'CheckoutController@createWalletOrder')->name('checkout.wallet.create');
    Route::get('/wallet/invoice/{invoice_id}/{order_pin}', 'CheckoutController@walletPaymentShowInvoicePage')->name('checkout.wallet.invoice');
});

Route::prefix('orders')->group(function () {
    Route::get('/', 'OrderController@index')->name('user.order.index');
    Route::get('/{invoiceNumber}', 'OrderController@show')->name('user.order.show');
});

Route::prefix('guides')->group(function () {
    Route::get('/how-to-find-your-epic-id', 'HomeController@findYourEpicId')->name('guides.findYourEpicId');
});

Route::prefix('discord')->group(function () {
    Route::post('/deliver', 'DiscordController@deliverOrder')->name('discord.deliverorder');
    Route::post('/refund', 'DiscordController@refundOrder')->name('discord.refundorder');
    Route::post('/restore', 'DiscordController@restoreOrder')->name('discord.restoreorder');
    Route::post('/acceptCashout', 'CashoutController@acceptCashout')->name('discord.acceptcashout');
    Route::post('/denyCashout', 'CashoutController@denyCashout')->name('discord.denycashout');
    Route::get('/no-discord-session', function() {
        $response = new Illuminate\Http\Response('Hello World');
        if(Cookie::get('cookies-accepted') !== null) {
            $response->withCookie(cookie('no-discord', true, 57600));
        }
        return $response;
    });
});

Route::prefix('newsletter')->group(function() {
    Route::post('/subscribe', 'NewsletterController@subscribe')->name('newsletter.subscribe');
});

Route::prefix('wallet')->middleware('auth')->group(function() {
    Route::get('/', 'WalletController@index')->name('wallet.index');
    // Route::post('/addFunds', 'WalletController@addFunds')->name('wallet.deposit');
});

Route::prefix('giftcard')->middleware('auth')->group(function() {
    Route::get('/', 'GiftcardController@index')->name('giftcard.index');
    Route::post('/create', 'GiftcardController@create')->name('giftcard.create');
});

Route::prefix('currency')->group(function() {
    Route::get('/', 'CurrencyController@index')->name('currency.index');
    Route::get('/setCurrency/{currency}', 'CurrencyController@setCurrency')->name('currency.set');
});

/** Paypal IPN */
Route::prefix('paypal')->group(function () {
    Route::post('/ipn/notify', 'PaypalController@postNotify')->name('paypal.ipn.notify');
});

Route::get('/email/send/news', 'NewsController@sendNews');

Route::get('/cookie', function () {
    dd(str_random(40));
    return Cookie::get('referral');
});

Route::get('/getrefID', function() {
    return 'localhost/?ref=' . \Hashids::encode(auth()->user()->id);
});

Route::prefix('cashout')->middleware('auth')->group(function() {
    Route::get('/', 'CashoutController@index')->name('cashout.index');
    Route::post('/request', 'CashoutController@requestCashout')->name('cashout.request');
});

Route::prefix('profile')->middleware('auth')->group(function() {
    Route::get('/', 'UserController@wallet')->name('user.index');
    Route::get('/wallet', 'UserController@wallet')->name('user.wallet');
    Route::post('/wallet/add-funds', 'WalletController@addFunds')->name('wallet.deposit');
    Route::get('/wallet/paypal/success/{amount}', 'WalletController@walletPayPalSuccess')->name('wallet.success.paypal');
    Route::get('/wallet/paysafecard/success/{userID}/{amount}', 'WalletController@walletPaysafecardSuccess')->name('wallet.success.paysafecard');
    Route::get('/wallet/paysafecard/notification/{userID}/{amount}', 'WalletController@paysafecardNotification')->name('wallet.notification.paysafecard');
    Route::get('/wallet/mollie/success', 'WalletController@walletSuccessMollie')->name('wallet.success.mollie');
    Route::post('/wallet/mollie/notification/{userID}/{amount}', 'WalletController@mollieNotification')->name('wallet.notification.mollie');
    Route::get('/wallet/error', 'WalletController@walletError')->name('wallet.error');
    Route::get('/orders', 'UserController@orders')->name('user.orders');
    Route::get('/discountcode', 'UserController@dcode')->name('user.dcode');
    Route::get('/my-items', 'UserController@myItems')->name('user.myItems');
    Route::get('/referrals', 'UserController@referrals')->name('user.referrals');
    Route::get('/ggpoints', 'UserController@ggPoints')->name('user.ggpoints');
    Route::get('/setttings', 'UserController@setttings')->name('user.settings');
    Route::post('/discountcode/changecode', 'DiscountCodeController@changeCode')->name('user.changedcode');
});

Route::prefix('help-center')->group(function() {
    Route::get('/', 'HomeController@helpIndex')->name('help.index');
    /* FAQ */
    Route::get('/payment-methods', 'HomeController@paymentMethods')->name('help.paymentmethods');
    /* LEGAL */
    Route::get('/privacy-policy', 'HomeController@privacy')->name('help.legal.privacy');
    Route::get('/terms-and-conditions', 'HomeController@toc')->name('help.legal.toc');
    Route::get('/cookie-policy', 'HomeController@cookie')->name('help.legal.cookies');
    Route::get('/right-of-withdrawal', 'HomeController@row')->name('help.legal.row');
});

Route::post('/navsearch', 'HomeController@searchAll')->name('home.search');

//Route::get('data', 'ArticleController@loadArticles');
