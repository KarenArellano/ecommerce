<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Controller;
use App\Models\SheduleCart;

class SheduleCartController extends Controller
{
    /**
     * this function shedule a email after passed the days 
     *
     * @param  Int Days 
     * 
     */
    public function sheduleDays(Request $request) 
    {
        $numer_days = $request['number_days'];

        if($numer_days == null) 
        { 
            return redirect()->back()->withErrors(__('El número de días no fue recibido!'));
        }

        SheduleCart::truncate();

        $shedule_carts = SheduleCart::firstOrCreate(['number_days' => $numer_days]);

        $shedule_carts->number_days = $numer_days;
        
        return redirect()->back()->with('statusSuccess', __('El numero de dias fue asignado correctamente'));
    }
}
