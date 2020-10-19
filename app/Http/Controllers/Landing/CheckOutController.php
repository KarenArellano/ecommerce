<?php

namespace App\Http\Controllers\Landing;

use App\Concerns\Landing\InteractsWithPixel;
use App\Concerns\Landing\InteractsWithShippo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Concerns\Landing\InteractsWithCoupon;
use App\Concerns\Landing\InteractsWithOrders;

class CheckOutController extends Controller
{
    use InteractsWithShippo, InteractsWithCoupon, InteractsWithOrders;
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request);
        
        session()->forget('percent_discount');

        if($this->emailExist($request))
        {
            return redirect()->back()->withInput()->withErrors([0 => "email ya registrado!"]);
        }

        $chooseAddress = $request->addres_option == "CHOOSE_ADDRESS" ? true : false;  

        $request->merge(['choose_address' => $chooseAddress]);

        $rules = $this->getRules($request, $chooseAddress);

        $validator = Validator::make($request->all(), $rules);

        $coupon = null;

        if (isset($request->code_coupon))
        {
            $coupon = $this->getCoupon($request);

            if(!$coupon)
            {
                return redirect()->back()->withInput()->withErrors([ 0 => "No fue encontrado su cupón!"]);
            }
        }

        if ($validator->fails()) 
        {
            return redirect()->back()->withInput()->withErrors($validator->errors()->all());
        }

        $resultValAddress = $this->validateAddress($request);

        if(!$resultValAddress['isValid'])
        {
            return redirect()->back()->withInput()->withErrors($resultValAddress['message']);
        }

        $this->sendEventInitCheckout();
        
        $this->createShipment($request);

        $products = $this->getProductsAuthOrNot();

        session()->put('user_data', request()->all());

        // dd(session()->get('user_data'));

        $first_coupon = $this->getCouponFirstAvailable();

        return view('landing.checkout.index', compact('request', 'products', 'first_coupon', 'coupon'));
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
        //
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

     /**
     * Put values User on Request if its Auth
     *
     * @param  Request  $request
     */
    public function putUserOnRequest(Request $request)
    {
        $user = Auth::user();

        $request->merge([
            'email' => $user->email,
            'name' => $user->name,
        ]);  
    }

    /**
     * Put values Address on Request if its Auth
     *
     * @param  Request  $request
     */
    public function putChoosenAddressOnRequest(Request $request)
    {
        $address = Address::find($request->address_stored_id);

        $user = Auth::user();

        $request->merge([
            'line' => $address->line ?? "",
            'secondary_line' => $address->secondary_line ?? "",
            'phone' => $address->phone ?? "",
            'zipcode' => $address->zipcode ?? "",
            'city' => $address->city ?? "",
            'state' => $address->state ?? "",
        ]);  
    }
}
