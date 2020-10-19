<?php

namespace App\Http\Controllers\Landing;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Facade\Ignition\QueryRecorder\Query;
use phpDocumentor\Reflection\Types\This;
use App\Concerns\Landing\InteractsWithCoupon;
use App\Concerns\Landing\InteractsWithPixel;
use App\Models\Coupon;

class ProductController extends Controller
{
    use InteractsWithPixel, InteractsWithCoupon, InteractsWithCoupon;

    /**
     * Product instance
     *
     * @var \App\Models\Product
     */
    protected $product;

    /**
     * Creates a new controller instance
     *
     * @param \App\Models\Product $product
     */
    public function __construct(Product $product)
    { 
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliceNumber = (int)request()->query('slice');
 
        $searchWord = request()->query('buscar');

        if($searchWord)
        {
             $this->sendEventSearchProduct($searchWord);
        }

        $products = $this->product
            ->filterByCategoryName(request()->query('categoria'))
            ->sortBypriceRange(request()->query('rango'))
            ->searchByName( $searchWord )
            ->search(request()->query('order'))
            ->paginate($sliceNumber);

        $categories = $this->product->all()->pluck('categories.*')->collapse()->unique('name')->values();

        $first_coupon = $this->getCouponFirstAvailable();

        return view('landing.products.index', compact('products', 'categories', 'first_coupon'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->product->findOrFail($id);

        $related = $product->related ? $this->product->whereIn('id', $product->related)->get() : [];

        $videos = $product->gallery()->where('mimetype', 'video')->get();

        // dd($videos);

        return view('landing.products.show', compact('product', 'related', 'videos'));
    }
}
