<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\LoginSession;
use Faker\Generator as Faker;

$factory->define(LoginSession::class, function (Faker $faker) {
    return [
        'at' => now()->subDays(random_int(1, 30)),
        'ip' => $faker->ipv4,
        'from' => $faker->country,
        'user_agent' => $faker->userAgent,
    ];
});
