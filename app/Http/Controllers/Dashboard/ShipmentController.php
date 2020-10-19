<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Dashboard\ShippoController;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::All();

        return view('dashboard.shippments.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $serviceName = explode('|', $request['_rate'])[1];

        $shippo = new ShippoController();

        $shipping = $shippo->getSelectedServiceRate($serviceName);

        $order = Order::find($request->orderId);

        $request = session()->get('request');

        // dd($shipping, $request, $order);

        $user = $order->user;

            $addressToShip = $user->addresses()->firstOrCreate(
                [
                    'line' => $request['line'],
                    'secondary_line' => $request['secondary_line'] ? $request['secondary_line'] : "",
                    'zipcode' => $request['zipcode'],
                    'city' => $request['city'],
                    'state' => $request['state'],
                    'phone' =>  $user->phone,
                    'country' => $request['country']
                ]
            );

            $order->shipment()->update([
                'address_id' => $addressToShip->id,
                'shipper' => $shipping['provider'],
                'rate_id' => $shipping['object_id'],
                'currency' => $shipping['currency'],
                'price' => $shipping['price'],
                'service_name' => $shipping['name']
            ]);
            
        return redirect()->route('dashboard.orders.index')->with('statusSuccess', __('Se reimprimió otra etiqueta de envio, a la ordern con transaction => :transaction_id', ['transaction_id' => $order->transaction_id]));
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
