<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Dashboard\ShippoController;
use App\Concerns\Landing\InteractsWithOrders;

class AddressController extends Controller
{
    use InteractsWithOrders;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
    public function store(Request $request, Order $order)
    {
        // dd("here store AddressController", $request, $order->id);

        $orderId = $request->orderId;

        $order = Order::find($request->orderId);

        if(isset($request->is_same))
        {
            $this->sameAdress($request, $order);
        }
        else
        {
            $errors = $this->otherAdress($request, $order);

            if($errors) 
            {
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }

        $shippo = new ShippoController();

        $shippo->getAllParcels($order);

        $resultValAddress = $shippo->validateAddress($request, $order);

        if (!$resultValAddress['isValid']) {
            return redirect()->back()->withInput()->withErrors($resultValAddress['message']);
        }

        $shippo->createShipment($request, $order);

        return $this->redirectToShipment($request, $orderId);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $orderId = $request->orderId;

        $order = Order::find($orderId);
        
        $address = $order->shipment->address;

        return view('dashboard.addresses.edit', compact('orderId', 'address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        // dd($request);
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
