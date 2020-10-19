<?php

namespace App\Http\Controllers\Landing;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Concerns\Landing\InteractsWithCart;
use App\Concerns\Landing\InteractsWithPixel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Cart;
use App\Concerns\Landing\InteractsWithCoupon;

class CartController extends Controller
{
    use InteractsWithPixel, InteractsWithCoupon;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->getProductsAuthOrNot();

        // dd($products);

        $first_coupon = $this->getCouponFirstAvailable();

        return view('landing.cart.index', compact('first_coupon','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $product = Product::findOrFail($request->id);

        $request->validate([
            'id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);


        $productOutStock = $this->outStock($request, $product);
        
        $this->sendEventAddToCart();

        if ($productOutStock == null) {

            $request->merge([
                'product' => $product,
            ]);

            $this->storeCartOnSession($request);

            return redirect()->route('landing.cart.index')->with('statusSuccess', __('El producto fue agregado a tu carrito.'));

        } else {

            return redirect()->route('landing.cart.index')->withErrors(__('El stock del producto esta limitado a :quantity :unity', $productOutStock));
        }

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * Taken: https://www.bootdey.com/snippets/view/shopping-cart-checkout#html
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($id);

        $productOutStock = $this->outStock($request, $product);

        if ($productOutStock == null) 
        {
            $request->merge([
                'product' => Product::findOrFail($id),
            ]);
    
            $this->updateOrInsertOnCart($request, true);
    
            return back()->with('statusSuccess', __('Cantidad actualizada.'));

        }else{

            return back()->withErrors(__('El stock del producto => :name, esta limitado a :quantity :unity', $productOutStock));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $this->deleteOnCart($id);

        if(Auth::check())
        {
            $userId = Auth::user()->id;

            Cart::where([
                'user_id' => $userId,
                'product_id' => $id
            ])->delete();
        }

        return back()->with('status', __('Producto eliminado de tu carrito.'));
    }
}
