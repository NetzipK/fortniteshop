<?php

namespace App\Nova\Metrics;

use Illuminate\Http\Request;
use Laravel\Nova\Metrics\Partition;

class PaymentMethods extends Partition
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        return $this->count($request, \App\Order::where('order_paid', true)->where('order_refunded', false), 'payment_gateway')
            ->label(function ($value) {
                switch ($value) {
                    case 'paypal':
                        return 'PayPal';
                    case 'Giropay':
                        return 'GiroPay';
                    case 'paysafecard':
                        return 'paysafecard';
                    case 'Creditcard':
                        return 'Credit Card';
                    default:
                        return ucfirst($value);
                }
        });
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'payment-methods';
    }
}
