<?php

namespace App\Concerns\Landing;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Coupon;

trait InteractsWithCart
{
    /**
     * Stores a cart on session.
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function storeCartOnSession(Request $request)
    {
        session()->has('cart') ? $this->updateOrInsertOnCart($request) : session()->put('cart.products', [$this->buildCart($request)]);

        session()->put('cart.products_count', count(session('cart.products')));

        if (auth()->check()) {
            $this->syncCartOnDatabase($request);
        }
    }

    /**
     * Prevents product duplications on session cart
     *
     * @param \Illuminate\Http\Request $request
     * @param bool $force
     *
     * @return array
     */
    protected function updateOrInsertOnCart(Request $request, $force = false)
    {
        // dd($request);

        if (Auth::check()) {
            $userId = Auth::user()->id;

            Cart::where([
                'user_id' => $userId,
                'product_id' => $request["product"]["id"]

            ])->update(['quantity' => $request->quantity]);

            $this->updateTotalAuth();
        }

        $products = $this->getProductsAuthOrNot();

        $cart = collect();

        if ($products->contains('product.id', $request->product->id)) {

            $cart = $products->map(function ($item) use ($request, $force) {

                if ((int) $item['product']['id'] === (int) $request->product->id) {
                    $item = $this->buildCart(
                        $request->merge([
                            'quantity' => $force ? $request->quantity : ($item['quantity'] + $request->quantity),
                        ])
                    );
                }

                return $item;
            });
        } else {

            $cart = $products->push(
                $this->buildCart($request)
            );
        }

        session()->put('cart.products', $cart->values()->all());
    }

    /**
     * Builds a cart on session.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected function buildCart(Request $request)
    {
        $cart = (new Cart([
            'product_id' => $request->product->id,
            'quantity' => $request->quantity,
            'price' => $request->product->price,
            'total' => $request->quantity * $request->product->price,
        ]));

        return $cart->load('product.cover')->toArray();
    }

    /**
     * Get All Products On Cart By Auth
     *
     * @return [Cart]
     */
    public function getProductsCart()
    {
        $userId = Auth::user()->id;

        $user = User::find($userId);

        $carts = $user->carts()->with('product.cover')->get()->toArray();

        return $carts;
    }

    /**
     * Update total price on session cart
     *
     * @return null
     */
    private function updateTotalSession()
    {
        $carts = collect(session('cart.products'));

        foreach ($carts as $cart) {
            if (!isset($cart['product_id'])) {
                return;
            }

            $productModel = Product::where('id', $cart["product_id"])->where('price', '!=', $cart["price"])->first();

            if ($productModel) {
                $this->deleteOnCart($cart["product_id"]);

                $cart = (new Cart([
                    'product_id' => $cart["product_id"],
                    'quantity' => $cart["quantity"],
                    'price' =>  $productModel->price,
                    'total' => $cart["quantity"] * $productModel->price,
                ]));

                $cartRel = $cart->load('product.cover')->toArray();

                session()->put('cart.products', [$cartRel]);

                session()->put('cart.products_count', count(session('cart.products')));
            }
        }
    }

    /**
     * Update total price on cart
     *
     * @return null
     */
    private function updateTotalAuth()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $cart = Cart::where('user_id', Auth::user()->id)->where('product_id', $product->id)->first();

            if ($cart) {
                $total = $product->price * $cart->quantity;

                $cart->update(["price" => $product->price, 'total' => $total]);
            }
        }
    }

    /**
     * Validate the quantity on stock
     *
     * @return back Redirect
     */
    public function validateAndRedirect($request, $product)
    {
        if ($product->stock < $request->quantity) {

            $unity = $product->stock > 1 ? 'unidades' : 'unidad';

            return back()->with('autofocus', true)->withErrors(__('El stock del producto esta limitado a :quantity :unity', ['quantity' => $product->stock, 'unity' => $unity]));
        }
    }

    /**
     * Clears the user cart And clear percent discount
     *
     * @return void
     */
    public function clearCart()
    {
        if (auth()->check()) {
            auth()->user()->carts()->delete();
        }

        session()->forget('percent_discount');
        session()->forget('cart');
        session()->forget('user_data');
    }

    /**
     * Stores a cart on database.
     *
     * @param \Illuminate\Http\Request $request
     */
    protected function syncCartOnDatabase(Request $request)
    {
        info('sync cart on database');

        $userId = Auth::user()->id;

        $user = User::find($userId);

        $cart = $user->carts()->firstOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $request->id
            ]
        );

        $cart->quantity = $request->quantity;
        $cart->total = $this->getTotal($request);
        $cart->price = $request['product']['unit_price'];

        $cart->save();
    }

    /**
     * Get total price on cart
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return Double
     */
    public function getTotal(Request $request)
    {
        return $request->quantity * $request['product']['unit_price'];
    }

    /**
     * Validate the quantity on stock
     *
     * @return back Redirect
     */
    public function outStock($request, $product)
    {
        if ($product->stock < $request->quantity) {

            $unity = $product->stock > 1 ? 'unidades' : 'unidad';

            return ['quantity' => $product->stock, 'unity' => $unity, 'name' => $product->name];
        }
    }

    /**
     * Check product stock before any payment complete
     *  @param $request
     * 
     *  @return First Product data
     */
    public function firstOutStock($request)
    {
        $products = $this->getProductsAuthOrNot();

        $products->each(function ($item) use ($request) {

            $product = Product::findOrFail($item['product']['id']);

            if ($product->stock < $item['quantity']) {

                $unity = $product->stock > 1 ? 'unidades' : 'unidad';

                $product = ['quantity' => $product->stock, 'unity' => $unity, 'product' => $product->name, 'product_id' => $product->id];

                $request->merge([
                    'OutStock' => $product
                ]);
            }
        });
    }

    /**
     * get Carts Autheticated or not 
     * 
     */
    public function getProductsAuthOrNot()
    {
        if (Auth::check()) {

            // dd(Auth::user());

            $this->updateTotalAuth();

            session()->forget('cart');

            session()->forget('cart.products');

            session()->forget('cart.products_count');

            session()->put('cart.products', $this->getProductsCart());

            session()->put('cart.products_count', count(session('cart.products')));

            return collect(session('cart.products'));
        }

        $this->updateTotalSession();

        return collect(session('cart.products'));
    }

    public function deleteOnCart($productId)
    {
        $products = $this->getProductsAuthOrNot()->filter(function ($item) use ($productId) {
            return $item['product']['id'] != $productId;
        })->values();

        $products->count() ? session()->put([
            'cart.products' => $products->all(),
            'cart.products_count' => $products->count(),
        ]) : session()->forget('cart');
    }

    /**
     * Return Coupon or return error
     */
    private function getCoupon(Request $request)
    {
        if (isset($request['code_coupon'])) {

            $name = $request['code_coupon'];

            $coupon = Coupon::select('*')

                ->where(function ($q) use ($name) {
                    $q->whereNull('start_date')
                        ->whereNull('end_date')
                        ->where('is_active', true)
                        ->where('name', $name);
                })
                ->orWhere(function ($q) use ($name) {
                    $q->where('start_date', '<=', date('Y-m-d H:i:s'))
                        ->where('end_date', '>=', date('Y-m-d H:i:s'))
                        ->where('is_active', true)
                        ->where('name', $name);
                })
                ->orderBy('percent', 'desc')
                ->first();

            if ($coupon) {
                session()->put('percent_discount', $coupon->percent);
            }

            return $coupon;
        }
    }
}
