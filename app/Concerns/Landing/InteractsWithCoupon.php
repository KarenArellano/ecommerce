<?php

namespace App\Concerns\Landing;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Coupon;

trait InteractsWithCoupon
{

    /**
     * Get First Coupon available and on limit date
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Coupon
     */

    function getCouponFirstAvailable()
    {
        $couponCls = new Coupon();

        $coupon = $couponCls->get();

        return $coupon;
    }
}
