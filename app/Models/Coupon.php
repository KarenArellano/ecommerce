<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'percent',
        'name',
        'start_date',
        'end_date'
    ];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_date', 'end_date'];

    /**
     * Relationship with the image model.
     *
     * @return. Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function cover()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Get First Coupon With percent highest
     *
     * @return. Coupon
     */
    public static function get()
    {
        return Coupon::select('*')
        ->where(function ($q)  {
            $q->whereNull('start_date')
                ->whereNull('end_date')
                ->where('is_active', true);
        })
        ->orWhere(function ($q) {
            $q->where('start_date', '<=', date('Y-m-d H:i:s'))
                ->where('end_date', '>=', date('Y-m-d H:i:s'))
                ->where('is_active', true);
        })
        ->orderBy('percent', 'desc')
        ->first();
    }
}
