<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipment;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $isCancelled = $faker->boolean;

    $isRefunded = !$isCancelled;

    return [
        'user_id' => User::inRandomORder()->first()->id,
        'transaction_id' => Order::getNextTransactionId(),
        'reference' => $faker->isbn13,
        'total' => $faker->randomFloat(2, $faker->randomNumber(2), $faker->randomNumber(4)),
        'origin' => $faker->randomElement(['android', 'ios', 'web']),
        'paid_with' => $faker->randomElement(['paypal', 'card', 'cash']),
        'paid_at' => $faker->dateTimeBetween('-1 year'),
        'notification_sent_at' => $faker->boolean ? now() : null,
        'cancelled_at' => $isCancelled ? $faker->dateTimeBetween('-6 months') : null,
        'refund_at' => $isRefunded ? $faker->dateTimeBetween('-2 months') : null,
    ];
});

$factory->afterCreating(Order::class, function ($order, $faker) {
    $order->products()->attach(
        $product = Product::inRandomORder()->first(), [
            'quantity' => $quantity = random_int(1, 3),
            'price' => $product->price,
            'total' => $quantity * $product->price,
        ]
    );

    $order->shipment()->save(
        factory(Shipment::class)->make([
            'address_id' => $order->user->addresses->first()->id,
        ])
    );
});
