<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $trackStock = $faker->boolean;

    return [
        'name' => $faker->sentence,
        'description' => $faker->realText,
        'sku' => $faker->ean13,
        'barcode' => $faker->isbn13,
        'track_stock' => $trackStock,
        'stock' => $trackStock ? $faker->randomNumber(random_int(1, 3)) : 0,
        'related' => collect(range(1, 15))->random(random_int(1, 4))->all(),
        'price' => $faker->randomFloat(2, 80, 250),
        'unit_price' => $faker->randomFloat(2, 80, 250),
        'created_at' => $faker->boolean ? now()->subDays(random_int(7, 30)) : now(),
    ];
});

$factory->afterCreating(Product::class, function ($product, $faker) {
    $product->cover()->create([
        'url' => 'https://source.unsplash.com/random/800x800/?sig=' . time(),
    ]);

    $product->gallery()->createMany(
        collect(range(1, 4))->map(function ($url) use ($faker) {
            return [
                'url' => 'https://source.unsplash.com/random/800x800/?sig=' . time(),
            ];
        })->all()
    );
});
