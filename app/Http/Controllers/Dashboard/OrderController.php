<?php

namespace App\Http\Controllers\Dashboard;

use App\Concerns\Landing\InteractsWithShippo;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Notifications\OrderShippedNotification;
use Illuminate\Support\Facades\Request;

// use App\Notifications\Dashboard\OrderShippedNotification;

class OrderController extends Controller
{
    use InteractsWithShippo;

    /**
     * Order instance
     *
     * @var App\Models\Order
     */
    protected $order;

    /**
     * Creates a new controller instance
     *
     * @param App\Models\Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ordersNoShipped = $this->order->latest()->whereNull('shipped_at')->orderBy('created_at', 'desc')->get();

        // dd($ordersNoShipped);

        $orderShipped = Order::whereNotNull('shipped_at')->orderBy('created_at', 'desc')->get();

        return view('dashboard.orders.index', compact('ordersNoShipped', 'orderShipped'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return $order;
    }

    /**
     * Change the order to shipped status.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $shipment = $order->shipment()->first();

        $rate_id = $shipment->rate_id;

        if(!$rate_id)
        {
            return redirect()->back()->withInput()->withErrors(__('No existe la referencia del rate')); 
        }

        $this->createTransaction($rate_id);

        $dataTrans = collect(session()->get('dataTrans'));

        // dd($dataTrans);

        if($dataTrans['messages_shippo'])
        {
            return redirect()->back()->withInput()->withErrors($dataTrans['messages_shippo'][0]['text']); 
        }

        return DB::transaction(function () use ($order, $dataTrans, $shipment) {

            $order->update([
                'shipped_at' => now()
            ]);

            $shipment->update([
                "tracking_number" => $dataTrans['tracking_number'],
                "tracking_url_provider" => $dataTrans['tracking_url_provider'],
                "label_url" => $dataTrans['label_url']
            ]);

             $notificaction = new OrderShippedNotification($order);
    
             $order->user->notify($notificaction);
            
             return redirect()->route('dashboard.orders.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        return DB::transaction(function () use ($order) {
            $order->update([
                'cancelled_at' => now(),
            ]);

            return redirect()->route('dashboard.orders.index');
        });
    }
}
