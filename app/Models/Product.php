<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'unit_price',
        'sku',
        'barcode',
        'track_stock',
        'stock',
        'related',
        'length',
        'width',
        'height',
        'weight',
        'mass_unit',
        'distance_unit'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'track_stock' => 'boolean',
        'related' => 'collection',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'marked_as_new',
        'gain_percentage',
    ];

    /**
     * Retrieve the markedAsNew attribute.
     *
     * @param. int      $days
     * @return string
     */
    public function getMarkedAsNewAttribute($days = 7)
    {
        return (int) $this->created_at->diff(now())->days <= $days;
    }

    /**
     * Retrieve the gainPercentage attribute.
     *
     * @return decimal
     */
    public function getGainPercentageAttribute()
    {
        $difference = $this->price - $this->unit_price;

        $percentage = ($difference / $this->unit_price) * 100;

        return $percentage;
    }

    /**
     * Relationship with the user model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favoredBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /**
     * Relationship with the cart model.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Relationship with the order model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot([
            'quantity', 'price', 'total'
        ])->withTimestamps();
    }

    /**
     * Relationship with the categoriz model.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

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
     * Relationship with the image model.
     *
     * @return. Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function gallery()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Query scope "scopeFilterByCategoryName".
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  nullable|string $name
     *
     * @return $this
     */
    public function scopeFilterByCategoryName($query, $name = null)
    {
        if (!is_null($name)) {
            $query->whereHas('categories', function ($category) use ($name) {
                $category->where(compact('name'));
            }); 
        }
    }

    /**
     * Query scope "scopeSortByprice".
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  nullable|string $direction
     *
     * @return $this
     */
    public function scopeSortByprice($query, $direction = null)
    {
        $query->orderBy('price', is_null($direction) ? 'asc' : $direction);
    }


    /**
     * Query scope "scopeSortByLatest".
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  nullable|string $direction
     *
     * @return $this
     */
    public function scopeSortByLatest($query, $direction = null)
    {
        $query->orderBy('created_at', is_null($direction) ? 'asc' : $direction);
    }

    /**
     * Query scope "sortBypriceRange".
     *
     * @param. Illuminate\Database\Query\Builder    $query
     * @param  type $range
     * @return. Illuminate\Database\Query\Builder
     */
    public function scopeSortBypriceRange($query, $ranges = null)
    {
        if (!is_null($ranges)) {
            $range = explode('-', $ranges);

            $query->where('price', '>=', $range[0])->where('price', '<=', $range[1]);
        }
    }

    /**
     * Query scope "scopeSearchByName".
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  nullable|string $criteria
     *
     * @return $this
     */
    public function scopeSearchByName($query, $criteria = null)
    {
        if (!is_null($criteria)) {
            $query->where('name', 'like', "%{$criteria}%");
        }
    }


    /**
     * Query scope "scopeSortByBestSeller".
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  nullable|string $direction
     *
     * @return $this
     */
    public function scopeSortByBestSeller($query, $direction = null)
    {
    //     dd($query);
    // select sum(order_product.quantity) as quantity, product_id  
    // from orders inner join order_product on orders.id = order_product.order_id 
    //             inner join products on products.id = order_product.product_id  group by product_id order by quantity desc;

        // $query->selectRaw('order_product.quantity as qty, order_product.product_id')
        //     ->join('order_product', 'order_product.product_id', '=', 'products.id')
        //     ->groupBy('order_product.product_id')
        //     ->orderBy('order_product.quantity ', 'desc')
        //     ->sum('order_product.quantity');
    }

    /**
     * Query scope "scopeSearch".
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @param  nullable|string $criteria
     *
     * @return $this
     */
    public function  scopeSearch($query, $criteria = null)
    {
        switch ($criteria) {
            case 'latest':

                return $query->sortByLatest('desc');

                break;

            case 'popular':
                
                // return $query->sortByBestSeller('desc');
                
                break;

            case 'asc' || 'desc':

                return $query->sortByprice($criteria);

                break;

            default:

                return $query;

                break;
        }
    }
}
