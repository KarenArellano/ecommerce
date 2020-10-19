<?php

/**
 * @var \Illuminate\Database\Eloquent\Factory $factory
 */
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\LoginSession;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
        'remember_token' => Str::random(10),
    ];
});

$factory->state(User::class, 'customers', function ($faker) {
    return [
        'is_administrator' => false,
        'is_customer' => true,
    ];
});

$factory->state(User::class, 'administrators', function ($faker) {
    return [
        'email' => 'administrador@ladyRecords.com',
        'is_administrator' => true,
        'is_customer' => false,
    ];
});

$factory->afterCreating(User::class, function ($user, $faker) {
    $user->loginSessions()->saveMany(
        factory(LoginSession::class, random_int(1, 10))->make()
    );
});
