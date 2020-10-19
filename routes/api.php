<?php

use App\Notifications\Landing\OrderCreatedNotification;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::get('preview', function () {
    $order = App\Models\Order::find(13);
    $order->user->notify(new OrderCreatedNotification($order));
});
