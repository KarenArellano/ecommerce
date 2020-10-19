<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'quantity',
        'price',
        'total',
        'was_reminded_hour',
        'was_reminded_day',
        'was_reminded_week'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * Bootstrap any model events.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        self::saving(function ($cart) {
            $cart->total = $cart->quantity * $cart->price;
        });
    }

    /**
     * Relationship with the user model.
     *
     * @return  Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with the product model.
     *
     * @return  Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
