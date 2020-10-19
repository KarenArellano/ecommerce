<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\Shipment;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'reference',
        'total',
        'origin',
        'paid_with',
        'paid_at',
        'notification_sent_at',
        'cancelled_at',
        'refund_at',
        'description',
        'shipped_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'paid_at',
        'notification_sent_at',
        'cancelled_at',
        'refund_at',
        'shipped_at'
    ];

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
     * @return  Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot([
            'quantity', 'price', 'total',
        ])->withTimestamps();
    }

    /**
     * Relationship with the shipment model.
     *
     * @return  Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    /**
     * Generates the next order transaction id
     * based on order count value
     *
     * @return srting
     */
    public static function getNextTransactionId()
    {
        $nextOrder = self::count() * time();

        return Str::replaceArray('?', [$nextOrder, now()->format('dmYHm')], 'ORD?AT?');
    }

    /**
     * Get the total´s quantity products
     * 
     *
     * @return String
     */
    public function getTotalProductsQuantity()
    {
        return strval($this->products()->sum('quantity'));
    }
}
