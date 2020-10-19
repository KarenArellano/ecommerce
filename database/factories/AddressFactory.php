<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'alias' => $faker->word,
        'phone' => $faker->phoneNumber,
        'user_in_charge' => $faker->name,
        'line' => $faker->streetAddress,
        'secondary_line' => $faker->boolean ? "$faker->streetSuffix, $faker->buildingNumber" : null,
        'city' => $faker->city,
        'state' => $faker->state,
        'country' => $faker->country,
        'zipcode' => $faker->postcode,
        'references' => $faker->text,
        'is_default' => $faker->boolean,
        'is_taxable' => $faker->boolean,
        'taxable_id' => Str::random(14),
        'phone' => $faker->phoneNumber,
    ];
});
