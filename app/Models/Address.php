<?php

namespace App\Models;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'alias',
        'user_in_charge',
        'line',
        'secondary_line',
        'city',
        'state',
        'country',
        'zipcode',
        'references',
        'is_taxable',
        'taxable_id',
        'phone',
        'is_default',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_default' => 'boolean',
        'is_taxable' => 'boolean',
    ];

    /**
     * Relationships morphing to this address model.
     *
     * @return  Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable()
    {
        return $this->morphTo();
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
}
