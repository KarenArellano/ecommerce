<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Address;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address_id',
        'order_id', 
        'shipper',
        'shipped_at',
        'tracking_number',
        'tracking_url_provider',
        'label_url',
        'rate_id',
        'currency',
        'price',
        'service_name'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'shipped_at',
    ];

    /**
     * Relationship with the order model.
     *
     * @return  Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship with the Address model.
     *
     * @return  Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

}
