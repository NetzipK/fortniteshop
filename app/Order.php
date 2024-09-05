<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     protected $casts = [
    'order_delievered_at' => 'dateTime',
];

    protected $fillable = [
        "invoice_number",
        "invoice_description",
        "email",
        "fortnite_username",
        "discord_username",
        "subtotal",
        "discount",
        "total",
        "paypal_token",
        "order_password",
        "user_id",
        "epic_id",
        "payment_gateway",
        "order_delievered",
        "order_delievered_by",
        "order_delievered_at",
        "order_failed",
        "order_paid",
        "discord_id",
        "platform",

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /** Order belongs to a user */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /** An order belongs to many articles */
    public function articles()
    {
        return $this->belongsToMany('App\Article')->withPivot(['quantity', 'price_per_unit', 'subtotal', 'name', 'subtotal']);
    }

    public function accounts()
    {
        return $this->belongsToMany('App\Account')->withPivot(['quantity', 'price_per_unit', 'subtotal', 'name', 'subtotal']);
    }

    public function skins()
    {
        return $this->belongsToMany('App\Skin', 'skin_order')->withPivot(['quantity', 'price_per_unit', 'subtotal', 'name', 'subtotal']);
    }

    public function discountcode()
    {
        return $this->belongsTo('App\DiscountCode', 'discount_code_id');
    }

    /** Set the order to failed by the given paypal token */
    public static function setFailedOrderByPaypalToken($paypalToken) {
        $order = Order::where('paypal_token', $paypalToken)->first();
        if (!$order->order_paid) {
            $order->order_failed = true;
        }
        $order->save();
    }

    public static function findByInvoiceNumber($invoice_number) {
        return Order::where('invoice_number', $invoice_number)->first();
    }

    public function getLink()
    {
        $paymentGatewayLower = strtolower($this->payment_gateway);
        if($paymentGatewayLower === "creditcard" || $paymentGatewayLower === "ideal" || $paymentGatewayLower === "sofort" || $paymentGatewayLower === "giropay") {
            $paymentGatewayLower = "mollie";
        }
        if($paymentGatewayLower === '') {
            $paymentGatewayLower = 'paypal';
        }
        return route("checkout.{$paymentGatewayLower}.invoice",  ['invoice_id' => $this->invoice_number, 'order_pin' => $this->order_password]);
    }

}
