<?php

namespace App\Http\Controllers\Landing;

use App\Concerns\Landing\InteractsWithCart;
use App\Concerns\Landing\InteractsWithPixel;
use App\Concerns\Landing\InteractsWithShippo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use FFI\Exception;

require_once(base_path() . "/Libraries/stripe-php-master/init.php");

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\StripeClient;
use Illuminate\Support\Facades\App;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
  use InteractsWithShippo, InteractsWithPixel;
  /**
   * Creates a new controller instance
   */
  public function __construct()
  {
  }

  /**
   * Return total price With discount or not, if has a code coupon
   */
  public function getTotal($total)
  {
      $percent = session()->get('percent_discount');

      Log::info("Total => " . $total);

      if (!$percent) 
      {
        return $total;
      }

      $discount = ($total * $percent) / 100;

      $total = $total - $discount;

      Log::info("Percent => " . $percent);
      Log::info("Discount => " . $discount);
      Log::info("Total with Discount => " . $discount);

      return $total;
  }

  public function createCharge(Request $request)
  {
    Log::info($request);

    if ($request['_rate'] == "undefined") {

      return json_encode(array('error' => __('No se pudó obtener el servicio de la paqueteria.')));
    }

    $serviceName = explode('|', $request['_rate'])[1];

    $shipping = $this->getSelectedServiceRate($serviceName);

    $products = collect(session('cart.products'));

    $total = floatval($products->sum('total'));

    if ($shipping['name'] != 'usps_priority') {
      $total += $shipping["price"];
    }

    $totalWithDiscountOrNot = $this->getTotal($total);

    // removes dot on total
    $finalTotal = number_format($totalWithDiscountOrNot, 2, '', '');

    Log::info('total =>' . $total);

    // dd($finalTotal);
    Log::info('finalTotal =>' . $finalTotal);

    $this->firstOutStock($request);

    // $this->sendEventInitCheckout();

    if ($request["OutStock"]) {

      return json_encode(array('error' => __('El stock del producto => :product, esta limitado a :quantity :unity', $request["OutStock"])));
    } else {

      // Set your secret key. Remember to switch to your live secret key in production!
      // See your keys here: https://dashboard.stripe.com/account/apikeys

      $keySecret = App::isProduction() ? env('STRIPE_SECRET_PRODUCTION') : env('STRIPE_SECRET_SANDBOX');

      try {

        Stripe::setApiKey($keySecret);

        $intent = \Stripe\PaymentIntent::create([
          'amount' => $finalTotal,
          'currency' => 'usd',
          // Verify your integration in this guide by including this parameter
          'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);

        return json_encode(array('client_secret' => $intent->client_secret));
      } catch (\Stripe\Exception\CardException $e) {
        // Since it's a decline, \Stripe\Exception\CardException will be caught

        Log::info('error Stripe =>' . $e);

        return json_encode(array('error' => $e->getError()->message));
      } catch (\Stripe\Exception\RateLimitException $e) {
        // Too many requests made to the API too quickly

        Log::info('error Stripe =>' . $e);

        return json_encode(array('error' => $e->getError()->message));
      } catch (\Stripe\Exception\InvalidRequestException $e) {
        // Invalid parameters were supplied to Stripe's API

        Log::info('error Stripe =>' . $e);

        return json_encode(array('error' => $e->getError()->message));
      } catch (\Stripe\Exception\AuthenticationException $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)

        Log::info('error Stripe =>' . $e);

        return json_encode(array('error' => $e->getError()->message));
      } catch (\Stripe\Exception\ApiConnectionException $e) {
        // Network communication with Stripe failed

        Log::info('error Stripe =>' . $e);

        return json_encode(array('error' => $e->getError()->message));
      } catch (\Stripe\Exception\ApiErrorException $e) {
        // Display a very generic error to the user, and maybe send
        // yourself an email

        Log::info('error Stripe =>' . $e);

        return json_encode(array('error' => $e->getError()->message));
      }
    }
  }
}
