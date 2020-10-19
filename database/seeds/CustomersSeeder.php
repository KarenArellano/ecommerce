<?php

use App\Models\Card;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 5)->states('customers')->create()->each(function ($user, $key) {
            $user->update([
                'email' => Str::replaceArray('?', [$key + 1], 'cliente?@manjarrez.com'),
            ]);

            $user->cards()->saveMany(
                factory(Card::class, random_int(1, 3))->make()
            );

            $user->carts()->saveMany(
                factory(Cart::class, random_int(1, 3))->make()
            );

            $user->favorites()->attach(
                Product::all()->random(random_int(1, 3))->pluck('id')->unique()->all()
            );

            $user->addresses()->saveMany(
                factory(Address::class, random_int(1, 2))->make()
            );

            factory(Order::class, random_int(1, 4))->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
