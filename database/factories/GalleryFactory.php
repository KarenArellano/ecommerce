<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Gallery;
use Faker\Generator as Faker;

$factory->define(Gallery::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->text,
        'tags' => $faker->randomElements(['categoria 1', 'categoria 2', 'categoria 3', 'categoria 4'], random_int(1, 4)),
    ];
});

$factory->afterCreating(Gallery::class, function ($gallery, $faker) {
    $gallery->image()->create([
        'url' => 'https://source.unsplash.com/random/800x800/?sig=' . time(),
    ]);
});
