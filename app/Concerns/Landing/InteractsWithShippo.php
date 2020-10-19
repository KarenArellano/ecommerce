<?php

namespace App\Concerns\Landing;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait InteractsWithShippo
{

    /**
     * Get ShippoController Instance
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return ShippoController
     */

    public function getShippoController()
    {
        return new \App\Http\Controllers\Landing\ShippoController();
    }

    /**
     * Get Price Shippo Service Level
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Shippo_Object $shippoResponse
     */
    public function createShipment($request)
    {
        $shippo = $this->getShippoController();

        $shippo->createShipment($request);
    }

    /**
     * Get the service data
     *
     * @param String
     *
     * @return Array $shippoResponse
     */
    public function getSelectedServiceRate(String $name)
    {
        $shippo = $this->getShippoController();

        return $shippo->getSelectedServiceRate($name);
    }

    /**
     * Create a transaction (shipping label) based on a rate object
     *
     * @param String object_id rate
     *
     * @return Array $shippoResponse
     */
    public function createTransaction(String $object_id)
    {
        $shippo = $this->getShippoController();

        return $shippo->createTransaction($object_id);
    }

    /**
     * Validate Shipping Address
     *
     * @param Request 
     *
     * @return Array $shippoResponse
     */
    public function validateAddress(Request $request)
    {
        $shippo = $this->getShippoController();

        return $shippo->validateAddress($request);
    }
}
