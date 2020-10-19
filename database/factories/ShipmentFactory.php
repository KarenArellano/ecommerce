<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Shipment;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Shipment::class, function (Faker $faker) {
    $hasLocationPickUp = $faker->boolean;

    return [
        'tracking_number' => Str::uuid(),
        'shipped_at' => $faker->dateTimeBetween('-1 week'),
    ];
});
