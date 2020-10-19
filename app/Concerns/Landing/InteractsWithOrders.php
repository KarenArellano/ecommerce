<?php

namespace App\Concerns\Landing;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Concerns\Landing\InteractsWithPixel;
use App\Models\Product;
use App\Notifications\Dashboard\OrderCreatedNotification as DashboardOrderCreatedNotification;
use App\Notifications\Landing\OrderCreatedNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

trait InteractsWithOrders
{
    use InteractsWithPixel;

    /**
     * Creates an order.
     *
     * @param \Illuminate\Http\Request $request
     * @param array $checkoutDetails
     *
     * @return \App\Models\Order
     */
    protected function createOrder(Request $request, array $checkoutDetails)
    {
        // dd($request);

        return DB::transaction(function () use ($request, $checkoutDetails) {
            $user = $this->resolveUser();

            $order = $user->orders()->create([
                'transaction_id' => $checkoutDetails['INVNUM'],
                'total' => $checkoutDetails['AMT'],
                'currency' => $checkoutDetails['CURRENCYCODE'],
                'origin' => 'web',
                'paid_with' => 'paypal',
                'paid_at' => now(),
                'description' => $checkoutDetails['DESC'],
            ]);

            $this->sendEventEndPurchase($request, $checkoutDetails['CURRENCYCODE'], $user);

            $this->createOrderProducts($order);

            $this->createOrderShipment($order, $user);

            return $order->fresh();
        });
    }

    public function createOrderWithStripe($responseStripe)
    {
        Log::info($responseStripe);

        if ($responseStripe == null || $responseStripe == NULL) {
            return null;
        }

        $response = json_decode($responseStripe);

        $paymentIntent = $response->paymentIntent;

        $price = substr_replace($paymentIntent->amount, '.', (strlen($paymentIntent->amount) - 2), 0);

        $order = DB::transaction(function () use ($paymentIntent, $price) {

            $user = $this->resolveUser();

            $order = $user->orders()->create([
                'transaction_id' => Order::getNextTransactionId(),
                'reference' => $paymentIntent->id,
                'total' => $price,
                'currency' => $paymentIntent->currency,
                'origin' => 'web',
                'paid_with' => 'Stripe',
                'paid_at' => now(),
                'description' => 'Stripe Payment',
            ]);

            $this->sendEventEndPurchase($paymentIntent->currency, $user);

            $this->createOrderProducts($order);

            $this->createOrderShipment($order, $user);

            $orderNotif = new OrderCreatedNotification($order);

            $orderNotifAdmin = new DashboardOrderCreatedNotification($order);

            $usersAdmin = User::all()->where('is_administrator', true);

            foreach ($usersAdmin as $admin) {
                $admin->notify($orderNotifAdmin);
            }

            $order->user->notify($orderNotif);

            $this->clearCart();

            return $order->fresh();
        });

        return $order;
    }

    /**
     * Resolve if it is any user logged in or create a new one
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Models\User
     */
    protected function resolveUser()
    {
        if (auth()->check()) {
            return auth()->user();
        }

        return DB::transaction(function () {

            $userData = session()->get('user_data');

            return User::firstOrCreate(
                [
                    'first_name' => $userData['first_name'],
                    'last_name' => $userData['last_name'],
                    'email' => $userData['email'],
                    'phone' => $userData['phone'],
                    'is_customer' => true,
                    'is_administrator' => false,
                    'password' => bcrypt(Str::random(10))
                ]
            );
        });
    }

    /**
     * Check product stock before any payment complete
     *  @param $request
     * 
     *  @return First Product data
     */
    public function getFirstProductNotOnStock($request)
    {
        $products = $this->getProductsAuthOrNot();

        $products->each(function ($item) use ($request) {

            $product = Product::findOrFail($item['product']['id']);

            if ($product->stock < $item['quantity']) {

                $unity = $product->stock > 1 ? 'unidades' : 'unidad';

                $product = ['quantity' => $product->stock, 'unity' => $unity, 'product' => $product->name, 'product_id' => $product->id];

                $request->merge([
                    'productNotStock' => $product
                ]);
            }
        });
    }


    /**
     * Creates order products.
     *
     * @param \App\Models\Order $order
     *
     * @return. void
     */
    protected function createOrderProducts(Order $order)
    {
        DB::transaction(function () use ($order) {

            $products = $this->getProductsAuthOrNot();

            // dd($products);

            $orderProducts = $order->products();

            $products->each(function ($item) use ($order, $orderProducts) {
                $orderProducts->attach(
                    $item['product']['id'],
                    [
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'total' => $item['total'],
                    ]
                );

                $product = $orderProducts->find($item['product']['id']);

                // dd($product);

                if ($product) {

                    if ($product->stock > 0) {
                        $product->decrement('stock', $item['quantity']);
                    }
                }
            });
        });
    }

    /**
     * Creates an order shipment.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @param \App\Models\User $user
     *
     * @return. void
     */
    protected function createOrderShipment(Order $order, User $user)
    {
        DB::transaction(function () use ($order, $user) {

            $userData = session()->get('user_data');

            // dd($userData);

            $addressToShip = $user->addresses()->firstOrCreate(
                [
                    'line' => $userData['line'],
                    'secondary_line' => $userData['secondary_line'] ? $userData['secondary_line'] : "",
                    'zipcode' => $userData['zipcode'],
                    'city' => $userData['city'],
                    'state' => $userData['state'],
                    'phone' => $userData['phone'],
                    'country' => $userData['country']
                ]
            );

            $shipping = session()->get('shipping_price');

            // dd($shipping);

            $order->shipment()->create([
                'address_id' => $addressToShip->id,
                'shipper' => $shipping['provider'],
                'rate_id' => $shipping['object_id'],
                'currency' => $shipping['currency'],
                'price' => $shipping['price'],
                'service_name' => $shipping['name']
            ]);
        });
    }

    /**
     * Get Rules for Checkout 
     *
     * @param \Illuminate\Http\Request $request
     * @param Bool $chooseAddress
     *
     * @return. Array
     */
    public function getRules(Request $request, $chooseAddress)
    {
        if (Auth::check()) {
            // dd("hare");

            $this->putUserOnRequest($request);

            // dd($request);

            if ($chooseAddress) {
                $this->putChoosenAddressOnRequest($request);

                return [
                    'phone' => ['required', 'string', 'min:11'],
                    'address_stored_id' => 'required|integer|min:1'
                ];
            } else {
                return [
                    'line' => ['required', 'string', 'max:255'],
                    'secondary_line' => ['nullable', 'string', 'max:255'],
                    'phone' => ['required', 'string', 'min:11'],
                    'zipcode' => ['required', 'string', 'max:255'],
                    'city' => ['required', 'string', 'max:255'],
                    'state' => ['required', 'string', 'max:255']
                ];
            }
        } else {
            return [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'email'],
                'line' => ['required', 'string', 'max:255'],
                'secondary_line' => ['nullable', 'string', 'max:255'],
                'phone' => ['required', 'string', 'min:11'],
                'zipcode' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'state' => ['required', 'string', 'max:255']
            ];
        }
    }

    /**
     * Get Rules for Checkout 
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return. Redirect or not
     */
    public function emailExist(Request $request)
    {
        // dd($request);

        if (auth()->check()) {
            return false;
        }

        $userExist = User::where('email', $request->email)->first();

        // dd($userExist);

        return $userExist ? true : false;
    }

    /**
     * Redirect to create new shippment
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return. Redirect or redirect Back with error
     */
    public function redirectToShipment(Request $request, $orderId)
    {
        if (isset($request['rates'])) 
        {
            $rates = $request['rates'];

            session()->put('request', $request->all());

            return view('dashboard.shippments.create', compact('orderId', 'rates'));
        }
        else 
        {
            return redirect()->back()->withErrors("No pudieron traerse las paqueterias!");
        }
    }

    /**
     * Handle To Same Addres Info
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return. Redirect or redirect Back with error
     */
    public function sameAdress(Request $request, Order $order)
    {
        $address = $order->shipment->address;

        $request->merge([
            "line" => $address->line,
            "secondary_line" => $address->secondary_line,
            "zipcode" => $address->zipcode,
            "country" => $address->country,
            "city" => $address->city,
            "state" => $address->state,
        ]);
    }

      /**
     * Handle To Same Addres Info
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return. Redirect or redirect Back with error
     */
    public function otherAdress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'line' => ['required', 'string', 'max:255'],
            'secondary_line' => ['nullable', 'string', 'max:255'],
            'alias' => ['nullable', 'string', 'max:255'],
            'zipcode' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255']
        ]);

        return $validator->fails() ? $validator->errors()->all() : null;
    }
}
