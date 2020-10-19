<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    $isPublished = true;

    return [
        'id' => Str::uuid(),
        'title' => $faker->sentence,
        'slug' => Str::slug($faker->sentence),
        'excerpt' => $faker->sentence,
        'content' => "[]",
        'is_published' => $isPublished,
        'published_at' => $isPublished ? $faker->dateTimeBetween('-5 years') : null,
        'updated_at' => $faker->dateTimeBetween('-5 years'),
        'cover' => 'https://source.unsplash.com/random/800x800/?sig=' . time(),
        'tags' => $faker->randomElements(['rock', 'art', 'design', 'draws', 'personal', 'miscellaneous'], random_int(1, 2)),
    ];
});
