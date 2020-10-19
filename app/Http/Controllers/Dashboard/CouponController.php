<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::All();

        return view('dashboard.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'percent' => ['required', 'numeric', 'min:1'],
            'name' => ['nullable', 'string', 'max:255', "unique:coupons"],
        ]);

        return DB::transaction(function () use ($request) {
            
            $coupon = Coupon::create($request->all());

            return redirect()->route('dashboard.coupons.edit', $coupon);
        });
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
    public function edit(Coupon $coupon)
    {
        return view('dashboard.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $messages = array(
            'start_date.nullable' => 'Campo fecha inicio es requerido en caso de limite de vencimiento',
            'end_date.nullable' => 'Campo fecha inicio es requerido en caso de limite de vencimiento',
            'cover_image.nullable' => 'Portada debe ser una imagen'
        );

        $validator = Validator::make($request->all(), [
            'percent' => ['required', 'numeric', 'min:1'],
            'name' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable'],
            'end_date' => ['nullable', 'after:start_date'],
            'cover_image' => ['nullable', 'image', 'max:5000'],
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('status.error', $validator->errors()->all());
        }

        if ($request["start_date"] != null || $request["end_date"] != null) 
        {
            if ($request["start_date"] != null && $request["end_date"] != null) 
            {
                $start_date = \Carbon\Carbon::parse($request["start_date"])->format('Y-m-d');
                $end_date = \Carbon\Carbon::parse($request["end_date"])->format('Y-m-d');

                $coupon->update([
                    'start_date' => $start_date,
                    'end_date' => $end_date
                ]);

                $coupon->save();
            } 
            else 
            {
                return redirect()->back()->with('status.error', __('Debe seleccionar ambas fechas, para fechas de vencimiento!'));
            }
        }

        return DB::transaction(function () use ($request, $coupon) {

            Log::info('On update Coupon');

            if ($request->hasFile('cover_image')) {

                $url = $request->file('cover_image')->store(config('app.env') . '/products', 's3');
              
                if ($coupon->cover)
                {
                    app('filesystem')->cloud()->delete($coupon->cover->url);

                    $coupon->cover()->update([
                        'url' => $url
                    ]);    
                }
                else
                {
                    $coupon->cover()->create([
                        'url' => $url
                    ]);
                }

                $coupon->save();
            }

            $coupon->update(
                [
                    'percent' => $request['percent'],
                    "name" => $request["name"],
                    'is_active' => isset($request["is_active"]) ? true : false,
                ]
            );

            return redirect()->route('dashboard.coupons.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        return DB::transaction(function () use ($coupon) {

            $coupon->delete();

            return redirect()->route('dashboard.coupons.index');
        });
    }
}
