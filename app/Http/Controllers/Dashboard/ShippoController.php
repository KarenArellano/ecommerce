<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use App\Concerns\Landing\InteractsWithCart;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
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
    public function createShipment(Request $request, Order $order)
    {
        $this->setApiKey();

        // ONLY usps AND ups
        $parcels = $this->getAllParcels($order);

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

        $addressTo = $this->getShippingAddress($request, $order);

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
    public function getShippingAddress(Request $request, Order $order)
    {
        $user = $order->user;

        $name = $user->name . " " . $user->first_name;

        $email = $user->email;

        $phone = $user->phone;

        $address = array(
            'name' => $name,
            'street1' => $request->line,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zipcode,
            'email' =>  $email,
            'phone' => $phone,
            'country' => 'US',
            'secondary_line' => $request->secondary_line
        );

        $arrayFake = array(
            "name" => $name,
            "street1" => "215 Clayton St.",
            "city" => "San Francisco",
            "state" => "CA",
            "zip" => "94117",
            "country" => "US",
            "email" => "karenarellanobarr@gmail.com"
        );

        return App::isProduction() ? $address : $arrayFake;
        // return $address;
    }

    public function getAllParcels(Order $order)
    {
        $products = $order->products;

        $length = 0.00;
        $width = 0.00;
        $height = 0.00;
        $weight = 0.00;
        $massUnit = '';
        $distanceUnit = '';

        $numItems = 0;

        foreach ($products as $product) {

            $cart = $product->pivot;

            if ($cart->quantity) 
            {
                $container = $cart->quantity == 2 ? 1 : $cart->quantity / 2; // This for cost of one parcel in two products

                if ($product->length) {
                    $subLength = $product->length * $container;

                    $length += $subLength;
                }

                if ($product->width) {
                    $subWidth = $product->width * $container;

                    $width +=  $subWidth;
                }

                if ($product->height) {
                    $subHeight = $product->height * $container;

                    $height += $subHeight;
                }

                if ($product->weight) {
                    $subWeight = $product->weight * $container;

                    $weight += $subWeight;
                }

                if ($product->mass_unit) {
                    $massUnit = $product->mass_unit;
                }

                if ($product->distance_unit) {
                    $distanceUnit = $product->distance_unit;
                }
            }
        }

        $info = [
            'name' => "Lady Records Item(s)",
            'length' => $length,
            'width' =>   $width,
            'height' =>  $height,
            'distance_unit' => $distanceUnit,
            'weight' => $weight,
            'mass_unit' => $massUnit,
        ];

        // dd($info);

        return $info;
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
    public function validateAddress(Request $request, Order $order)
    {
        $this->setApiKey();

        $address = $this->getShippingAddress($request, $order);

        // dd($address, "ff");

        $toAddress = \Shippo_Address::create($address);

        $result = \Shippo_Address::validate($toAddress['object_id']);

        if ($result['validation_results']['is_valid']) {
            return array('isValid' => $result['validation_results']['is_valid']);
        }

        return array('isValid' => $result['validation_results']['is_valid'], 'message' => $result['validation_results']['messages'][0]['text']);
    }
}