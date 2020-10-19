<?php

use App\Models\Order;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Landing Routes
|--------------------------------------------------------------------------
|
| Here is where you can register landing routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
// Route::view('/', 'landing.index');

Route::get('/', 'ProductController@index');

Route::view('acerca', 'landing.about')->name('landing.about');

// Route::view('galeria', 'landing.gallery')->name('landing.gallery');

// Route::resource('noticias', 'PostController')->only([
//     'index', 'show',
// ])->names('landing.posts');

Route::get('contacto', 'ContactController@index')->name('landing.contact');
Route::post('contacto', 'ContactController@sendNotificationFromContactForm')->name('landing.contact.send.notification');

Route::resource('productos', 'ProductController')->only([
    'index', 'show',
])->names('landing.products');

Route::get('carrito/limpiar', 'CartController@clearCart')->name('landing.cart.clear');
Route::resource('carrito', 'CartController')->only([
    'index', 'store', 'update', 'destroy',
])->names('landing.cart');

Route::post('contactpixel', 'ContactController@sendPixelContact');

Route::post('ordenes/paypal/webhook', 'OrderController@ipnListener')->name('landing.order.paypal.wehook');
Route::get('ordenes/paypal/success', 'OrderController@expressCheckoutSuccess')->name('landing.order.paypal.success');
Route::resource('ordenes', 'OrderController')->names('landing.order');

Route::middleware('auth')->group(function () {
    Route::resource('cuenta/direcciones', 'AddressController')->names('landing.account.addresses');
    Route::get('cuenta', 'AccountController@index')->name('landing.account.index');
    Route::post('cuenta', 'AccountController@store')->name('landing.account.update');
    Route::delete('cuenta', 'AccountController@destroy')->name('landing.account.destroy');
});

// Route::get('preview', function () 
// {    
//     $order = App\Models\Order::find(3);

//     // dd($order->shipment);

//     return view('landing.notifications.orders.shipped')->with('order', $order); 

  

//     // return view('landing.notifications.orders.created')->with('order', $order);
    
//     // $order->user->notify(new OrderCreatedNotification($order));
// });

//Dont change name to checkout helps on stripe card element, to only load on this view
Route::resource('checkout', 'CheckOutController')->names('landing.checkout');

Route::post('getIntent', 'StripeController@createCharge');

