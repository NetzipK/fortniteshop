<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;

class Order extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Order';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'email',
        'invoice_number'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Invoice Number'),
            Text::make('Order Password'),
            Boolean::make('Order Paid'),
            Boolean::make('Order Failed'),
            Boolean::make('Order Refunded'),
            // Currency::make('Total'),
            Text::make('Platform'),
            Text::make('Email'),
            Text::make('Epic Id'),
            Text::make('Discord Id'),
            BelongsTo::make('User')->nullable(),
            Text::make('Payment Gateway')->hideFromIndex(),//
            // Currency::make('Subtotal'),
            Currency::make('Discount')->hideFromIndex(),//
            Boolean::make('Order Delievered'),//
            Text::make('Order Delievered By'),
            DateTime::make('Order Delievered At'),
            Text::make('Invoice Description')->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [new Metrics\TotalPaid, (new Metrics\PaymentMethods)->width('2/3')];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [new Filters\OrderPaid];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
