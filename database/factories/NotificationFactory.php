<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Notifications\DatabaseNotification;

$factory->define(DatabaseNotification::class, function (Faker $faker) {
    return [
        'id' => Str::uuid(),
        'type' => User::class,
        'data' => $faker->words(),
        'read_at' => $faker->boolean ? $faker->dateTimeBetween('-2 weeks') : null,
    ];
});
