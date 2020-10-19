<?php

namespace App\Http\Controllers\Landing;

use App\Concerns\Landing\InteractsWithCart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

//comment if is local enviroment
include_once(base_path() . "/Libraries/shippo-php-client-master/lib/Shippo.php");

class ShippoController extends Controller
{
    use InteractsWithCart;

    /**
     *  Key
     *
     * @var String
     */
    protected $key;


    /**
     * Creates a new controller instance
     */
    public function __construct()
    {
        $this->key = App::isProduction() ? env('SHIPPO_API_KEY_PROD') : env('SHIPPO_API_KEY');
    }

    /**
     * Set Credentials
     */

    private function setApiKey()
    {
        Log::info("Api key Shippo => ".$this->key);

        \Shippo::setApiKey($this->key);
    }

    /**
     * Create a the shipping data for a user
     * 
     * @param Request
     * @return array 
     */
    public function createShipment($request)
    {
        $this->setApiKey();

        // ONLY usps AND ups
        $parcels = $this->getAllParcels();

        $fromAddress = array(
            'name' => 'Lady Record',
            'company' => 'Lady Récords LLC',
            'street1' => 'bridge lane',
            'street_no' => '4861',
            'city' => 'Masón',
            'state' => 'Ohio',
            'zip' => '45040',
            'country' => 'US',
            'metadata' => 'Apartment 12'
        );

        $addressTo = $this->getShippingAddress($request);

        $shipment = \Shippo_Shipment::create(
            array(
                "address_from" => $fromAddress,
                "address_to" => $addressTo,
                "parcels" => $parcels,
                "async" => false
            )
        );
        $shipmentObjId = $shipment['object_id'];

        $shippingRates = $this->getShippingRates($shipmentObjId);

        // dd($shippingRates);

        $this->storeRates($shippingRates, $request);
    }

    public function storeRates($shippingRates, Request $request)
    {
        $rates = array();

        // dd($shippingRates);

        foreach ($shippingRates['results']  as $key => $rate) {

            $token = $rate['servicelevel']['token'];

            if ($token == 'usps_priority' || $token == 'usps_priority_express' || $token == 'ups_next_day_air') {
                $rate = array(
                    'provider' => $rate['provider'],
                    'name' => $rate['servicelevel']['token'],
                    'price' => $rate['amount'],
                    'currency' => $rate['currency'],
                    'duration_terms' => $rate['duration_terms'],
                    'object_id' => $rate['object_id'],
                    'name_radable' => $rate['servicelevel']['name']
                );

                $rates[] = $rate;
            }
        }

        session()->put('rates', $rates);

        $request->merge(['rates' => $rates]);
    }

    /**
     * Get Shipping Rate also store on Session 
     * 
     * 
     * @param String
     * @return array
     */
    public function getSelectedServiceRate(String $name)
    {
        $rates = collect(session()->get('rates'));

        foreach ($rates as $key => $rate) {
            if ($rate['name'] == $name) {
                session()->put('shipping_price', $rate);

                return $rate;
            }
        }
    }

    /**
     * Get Shipping Rates
     * 
     * @param Request
     * @return array
     */
    public function getShippingRates($shipmentObjId)
    {
        $this->setApiKey();

        return \Shippo_Shipment::get_shipping_rates(
            array(
                'id' => $shipmentObjId,
                'currency' => 'USD'
            )
        );
    }

    /**
     * Return the address To Shipping
     * 
     * @param Address, User
     * @return array
     */
    public function getShippingAddress($request)
    {
        // dd($request, Auth::user(), "shippo");

        $address = array(
            'name' => $request->name . " " . $request->first_name,
            'street1' => $request->line,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zipcode,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => 'US',
            'secondary_line' => $request->secondary_line
        );

        // dd($address);

        $arrayFake = array(
            "name" => $request->name . " " . $request->first_name,
            "street1" => "215 Clayton St.",
            "city" => "San Francisco",
            "state" => "CA",
            "zip" => "94117",
            "country" => "US",
            "email" => $request->email
        );

        return App::isProduction() ? $address : $arrayFake;
        // return $address;
    }

    public function getAllParcels()
    {
        $carts = $this->getProductsAuthOrNot();

        $length = 0.00;
        $width = 0.00;
        $height = 0.00;
        $weight = 0.00;
        $massUnit = '';
        $distanceUnit = '';

        $numItems = 0;

        foreach ($carts  as $key => $item) {

            if (isset($item['quantity'])) {
                $container = $item['quantity'] == 2 ? 1 : $item['quantity'] / 2; // This for cost of one parcel in two products

                if (isset($item['product']['length'])) {
                    $subLength = $item['product']['length'] * $container;

                    $length += $subLength;
                }

                if (isset($item['product']['width'])) {
                    $subWidth = $item['product']['width'] * $container;

                    $width +=  $subWidth;
                }

                if (isset($item['product']['height'])) {
                    $subHeight = $item['product']['height'] * $container;

                    $height += $subHeight;
                }

                if (isset($item['product']['weight'])) {
                    $subWeight = $item['product']['weight'] * $container;

                    $weight += $subWeight;
                }

                if (isset($item['product']['mass_unit'])) {
                    $massUnit = $item['product']['mass_unit'];
                }

                if (isset($item['product']['distance_unit'])) {
                    $distanceUnit = $item['product']['distance_unit'];
                }
            }
        }

        return [
            'name' => "Lady Records Item(s)",
            'length' => $length,
            'width' =>   $width,
            'height' =>  $height,
            'distance_unit' => $distanceUnit,
            'weight' => $weight,
            'mass_unit' => $massUnit,
        ];
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
        $this->setApiKey();

        $transaction = \Shippo_Transaction::create(array(
            'rate' => $object_id,
            'label_file_type' => "PDF",
            'async' => false
        ));

        Log::info($transaction);

        $dataTrans = [
            'tracking_number' => $transaction['tracking_number'],
            'tracking_url_provider' => $transaction['tracking_url_provider'],
            'label_url' => $transaction['label_url'],
            'messages_shippo' => $transaction['messages']
        ];

        session()->put('dataTrans', $dataTrans);
    }

    /**
     * Create and Validate Address
     *
     * @param Request
     *
     * @return Array
     */
    public function validateAddress(Request $request)
    {
        $this->setApiKey();

        $address = $this->getShippingAddress($request);

        $toAddress = \Shippo_Address::create($address);

        $result = \Shippo_Address::validate($toAddress['object_id']);

        if ($result['validation_results']['is_valid']) {
            return array('isValid' => $result['validation_results']['is_valid']);
        }

        return array('isValid' => $result['validation_results']['is_valid'], 'message' => $result['validation_results']['messages'][0]['text']);
    }
}
