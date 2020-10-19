<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cart;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Cart::class, function (Faker $faker) {
    $quantity = random_int(1, 9);

    $product = Product::inRandomOrder()->first();

    return [
        'product_id' => $product->id,
        'quantity' => $quantity,
        'price' => $product->pricd,
    ];
});
