<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Currency;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\BelongsToMany;

class Account extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Account';

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
            Text::make('External Id'),
            Boolean::make('Active'),
            Boolean::make('Is Featured'),
            Boolean::make('Is Sale'),
            Text::make('Name'),
            //Currency::make('Price'),
            Trix::make('Description'),
            Text::make('Username'),
            Text::make('Password'),
            Boolean::make('Full Access'),
            Number::make('VBucks'),
            Number::make('Account Level'),
            Boolean::make('PVE'),

            Boolean::make('Battle Pass')->hideFromIndex(),
            Number::make('Battle Pass Level')->hideFromIndex(),
            Number::make('Outfits')->hideFromIndex(),
            Number::make('Back Bling')->hideFromIndex(),
            Number::make('Pickaxes')->hideFromIndex(),
            Number::make('Gliders')->hideFromIndex(),
            Number::make('Dances')->hideFromIndex(),

            Text::make('Campagne')->hideFromIndex(),
            Boolean::make('Standard Edition')->hideFromIndex(),
            Boolean::make('Deluxe Edition')->hideFromIndex(),
            Boolean::make('Super Deluxe Edition')->hideFromIndex(),

            BelongsToMany::make('Outfit'),
            BelongsToMany::make('Backbling'),
            BelongsToMany::make('Pickaxe'),
            BelongsToMany::make('Glider'),
            BelongsToMany::make('Dance'),

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
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
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
