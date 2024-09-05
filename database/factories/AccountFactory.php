<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Account::class, function (Faker $faker) {
    return [
        'external_id' => $faker->uuid,
        'name' => $faker->text(30),
        'price' => $faker->numberBetween(5, 250),
        'active' => true,
        'full_access' => $faker->boolean,
        'vbucks' => $faker->numberBetween(0, 10000),
        'account_level' => $faker->numberBetween(1, 100),
        'available_on_PC' => $faker->boolean,
        'available_on_PS4' => $faker->boolean,
        'available_on_XBOX' => $faker->boolean,
        'available_on_SWITCH' => $faker->boolean,
        'pve' => $faker->boolean,
        'battle_pass' => $faker->boolean,
        'battle_pass_level' => $faker->numberBetween(0, 100),
        'outfits' => $faker->numberBetween(0, 250),
        'gliders' => $faker->numberBetween(0, 250),
        'back_bling' => $faker->numberBetween(0, 250),
        'pickaxes' => $faker->numberBetween(0, 250),
        'dances' => $faker->numberBetween(0, 250),
        'homebase_level' => $faker->numberBetween(1, 100),
        'campagne' => 'T' . $faker->numberBetween(1, 4),
        'standard_edition' => $faker->boolean,
        'deluxe_edition' => $faker->boolean,
        'super_deluxe_edition' => $faker->boolean,
    ];
});
