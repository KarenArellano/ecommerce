<?php

namespace App\Concerns\Landing;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Concerns\Landing\InteractsWithCart;
use App\Concerns\Landing\InteractsWithOrders;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Notifications\Landing\OrderCreatedNotification;
use App\Concerns\Landing\InteractsWithShippo;
use App\Models\Product;
use App\Notifications\Dashboard\OrderCreatedNotification as DashboardOrderCreatedNotification;

trait InteractsWithPaypal
{
    use InteractsWithOrders, InteractsWithShippo;

    /**
     * Init a new paypal express checkout
     *
     * @return \Srmklive\PayPal\Services\ExpressCheckout
     */
    protected function paypal()
    {
        return (new ExpressCheckout())->addOptions([
            'BRANDNAME' => config('app.name'),
            'LOGOIMG' => asset('images/logo-checkout'),
            'CHANNELTYPE' => 'Merchant',
        ]);
    }

    /**
     * Starts a new paypal checkout
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function processOrderWithPaypal(Request $request)
    {
        // dd($request);

        session()->flashInput(request()->all());

        $expressCheckoutResponse = $this->paypal()->setExpressCheckout($this->getFormattedCart($request));

        if ($url = $expressCheckoutResponse['paypal_link']) {
            error_log($url);

            return redirect($url);
        }

        error_log($url);

        return redirect()->back()->withInput()->with('status.error', __('Algo salió mal con PayPal: :error', ['error' => $expressCheckoutResponse['L_LONGMESSAGE0']]));
    }

    /**
     * Process the paypal success ckeckout
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function expressCheckoutSuccess(Request $request)
    {
        DB::beginTransaction();

        session()->flashInput(request()->all());

        $cart = $this->getFormattedCart($request);

        $checkoutDetails = $this->paypal()->getExpressCheckoutDetails($request->get('token'));

        if (!in_array(strtoupper($checkoutDetails['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            return redirect()->back()->withInput()->with('status.error', __('Error al procesar el pago con PayPal: :error', ['error' => $checkoutDetails['L_SHORTMESSAGE0']]));
        }

        if ($order = $this->createOrder($request, $checkoutDetails)) {
            $checkoutPayment = $this->paypal()->doExpressCheckoutPayment($cart, $request->get('token'), $request->get('PayerID'));

            if (Str::contains(strtoupper($checkoutPayment['PAYMENTINFO_0_PAYMENTSTATUS']), 'COMPLETED')) {
                
                DB::commit();

                $orderNotif = new OrderCreatedNotification($order);

                $order->user->notify($orderNotif);

                $orderNotifAdmin = new DashboardOrderCreatedNotification($order);

                $usersAdmin = User::all()->where('is_administrator', true);

                foreach ($usersAdmin as $admin) {
                    $admin->notify($orderNotifAdmin);
                }

                $this->clearCart();

                return redirect()->route('landing.cart.index')->with('status.order.success', $order);
            } else {
                DB::rollback();
            }
        }

        return redirect()->back()->withInput()->with('status.error', __('El proceso de pago no se ha efectuado correctamente, si este problema persiste, contacte a PayPal'));
    }

    /**
     * Gets the formatted cart.
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return array
     */
    protected function getFormattedCart(Request $request)
    {
        $products = $this->getProductsAuthOrNot();

        $items = $products->map(function ($item) {

            return [
                'name' => $item['product']['name'],
                'price' => $item['price'],
                'qty' => $item['quantity'],
            ];
        });

        $subtotal = $products->sum('total');

        // dd($total);

        if (session()->get('shipping_price')) {

            $shipping = session()->get('shipping_price');

            // dd($shipping);

            if ($shipping['name'] != 'usps_priority') {
                $shipping =
                    [
                        'name' => $shipping["name_radable"],
                        'price' => $shipping["price"],
                        'qty' => 1
                    ];

                $items->push($shipping);

                $subtotal += $shipping["price"];
            }
        }

        $total = number_format($subtotal, 2);

        if (session()->get('percent_discount')) {

            $percent = session()->get('percent_discount');

            $discount = ($subtotal * $percent) / 100;

            $discountNeg = - 1 * $discount;

            $discount = number_format($discountNeg, 2);
            
            $item =
                [
                    'name' => "Discount",
                    'price' => $discount,
                    'qty' => 1
                ];

            $items->push($item);

            // dd($discount);

            $total = $subtotal - $discount;

            session()->forget('percent_discount');

            // dd("subtotal = ".$subtotal, "total = ".$total, "discount = ". $discount, $items);
        }

        // dd($items, $total);

        return [
            'items' => $items->values()->toArray(),
            'invoice_id' => Order::getNextTransactionId(),
            'invoice_description' => __('Compra de :count producto(s) en :app', ['count' => $products->count(), 'app' => config('app.name')]),
            'return_url' => route('landing.order.paypal.success', request()->all()),
            'cancel_url' => route('landing.cart.index'),
            'total' => $total,
        ];
    }

    /**
     * { function_description }
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function ipnListener(Request $request)
    {
        // dd($request);
        if (
            $request->has('invoice') &&
            $request->has('payment_status') &&
            strtoupper($request->payment_status) === 'COMPLETED'
        ) {
            if ($order = Order::where('transaction_id', $request->invoice)->first()) {

                $order->update(['reference' => $request->txn_id]);

                $order->user->notify(new OrderCreatedNotification($order->fresh()));
            }
        }

        return response()->json();
    }
}
