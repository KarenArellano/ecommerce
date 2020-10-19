<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Card;
use Faker\Generator as Faker;

$factory->define(Card::class, function (Faker $faker) {
    return [
        'holder_name' => $faker->name,
        'token' => 'tk_' . Str::random(20),
        'brand' => $faker->creditCardType,
        'last_four' => substr($faker->creditCardNumber, -4),
        'expiration_month' => $faker->creditCardExpirationDate->format('m'),
        'expiration_year' => $faker->creditCardExpirationDate->format('y'),
        'is_default' => $faker->boolean,
    ];
});
