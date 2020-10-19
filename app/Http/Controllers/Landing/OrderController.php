<?php

namespace App\Http\Controllers\Landing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Concerns\Landing\InteractsWithPaypal;
use App\Concerns\Landing\InteractsWithShippo;

class OrderController extends Controller
{
    use InteractsWithPaypal;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        if ($request['method'] == 'stripe') {

            $order = $this->createOrderWithStripe($request['response_stripe']);

            if ($order) {
                return redirect()->route('landing.cart.index')->with('status.order.success', $order);
            } else {
                return redirect()->back()->withInput()->withErrors(__("El pago no fue recibido por el servidor!"));
            }
        }

        if ($request['_rate'] == null) {
            return redirect()->back()->withInput()->withErrors(__('No se pudo obtener el servicio de la paqueteria.'));
        }

        $serviceName = explode('|', $request['_rate'])[1];

        $this->getSelectedServiceRate($serviceName);

        $request->validate([
            'method' => ['required', 'string', 'in:card,paypal'],
        ]);

        $this->firstOutStock($request);

        $this->sendEventInitCheckout();

        if ($request["OutStock"]) {
            return redirect()->back()->withInput()->withErrors(__('El stock del producto => :product, esta limitado a :quantity :unity', $request["OutStock"]));
        } else {
            return $this->processOrderWithPaypal($request);
        }
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
