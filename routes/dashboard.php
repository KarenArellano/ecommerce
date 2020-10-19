<?php
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register dashboard routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::get('/', 'HomeController@index')->name('dashboard.home');

Route::resource('address', 'AddressController')->names('dashboard.address');

Route::resource('orders', 'OrderController')->names('dashboard.orders');
Route::resource('products', 'ProductController')->names('dashboard.products');
Route::resource('categories', 'CategoryController')->names('dashboard.categories');
// Route::resource('posts', 'PostController')->names('dashboard.posts');
Route::post('posts/{post}/attach/image', 'PostController@attachImage');
// Route::resource('galleries', 'GalleryController')->names('dashboard.galleries');

Route::resource('envios', 'ShipmentController')->names('dashboard.shippments');
Route::post('shedule', 'SheduleCartController@sheduleDays');

Route::resource('usuarios', 'UserController')->names('dashboard.users');

Route::resource('usuarios', 'UserController')->names('dashboard.users');
Route::get('download/users', 'UserController@dowload');
Route::get('dowload/users/order', 'UserController@dowloadWithOrder');
Route::post('send/email/user', 'UserController@sendEmail');

Route::resource('coupons', 'CouponController')->names('dashboard.coupons');