<?php

namespace App\Concerns\Landing;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait InteractsWithPixel
{
    use InteractsWithCart;

    public $productsQtyTotal = 0; 

    /**
     * Get all products ids on cart
     * @param null
     * 
     * @return Array Int
     */
    public function getProductIds()
    {
        $products = $this->getProductsAuthOrNot();

        $content_ids = array();

        foreach ($products as $itemCar) {

            $content_ids[] = $itemCar['product']['id'];

            $this->productsQtyTotal += $itemCar['quantity'];
        }

        return $content_ids;
    }

    /**
     * Get the quantity products and id product in cart 
     * @param null
     * 
     *  @return Array Objects
     */
    public function getProductQuantities()
    {
        $products = $this->getProductsAuthOrNot();

        $contents = array();

        foreach ($products as $itemCar) {

            $infoProduct = array(
                'id' => strval($itemCar['product']['id']),
                'quantity' => intval($itemCar['quantity'])
            );

            $contents[] = $infoProduct;
        }

        return $contents;
    }

    /**
     * make params to pixel Facebook
     *  @param String, User Model
     * 
     * @return Array Objects
     */

    public function getParamsProducts($searchWord = null)
    {
        $content_ids = $this->getProductIds();

        $contents = $this->getProductQuantities();

        $user = Auth::check() ? Auth::user() : null;

        $parms = array(
            "content_category" => "Products",
            'content_ids' => $content_ids,
            "contents"  => $contents,
            "content_name" => "products",
            "content_type" => "products",
            "num_items" => $this->productsQtyTotal,
            "currency" => "USD"
        );

        $parms["value"] = $user ? $user->id : 0;

        if ($searchWord) {
            $parms["search_string"] = $searchWord;
        }

        $jsonParams = json_encode($parms, true);

        return $jsonParams;
    }

    /**
     * Create an event for payment request to pixel Facebook
     * @param Request, String, User Obj 
     */
    public function sendEventEndPurchase($currency, $user)
    {
        $jsonParams = $this->getParamsProducts($currency, $user);

        $pixel = new \App\Http\Controllers\FacebookPixelController();

        $pixel->sendEvent($pixel->endPurchase, $jsonParams);
    }

    /**
     * Create an event for add to Cart to pixel Facebook
     * 
     */
    public function sendEventAddToCart()
    {
        $jsonParams = $this->getParamsProducts();

        $pixel = new \App\Http\Controllers\FacebookPixelController();

        $pixel->sendEvent($pixel->addToCart, $jsonParams);
    }

    /**
     * Send event when init Checkout
     * 
     */
    public function sendEventInitCheckout()
    {
        $jsonParams = $this->getParamsProducts();

        $pixel = new \App\Http\Controllers\FacebookPixelController();

        $pixel->sendEvent($pixel->initCheckout, $jsonParams);
    }

    /**
     * Create an event for registration to pixel Facebook
     * 
     */
    public function sendEventRegistration()
    {
        $userId = Auth::check() ? Auth::user()->id : null;

        $parms = array(
            "status" => true,
            "value" =>  $userId,
            "content_name" => "Register User"
        );

        $jsonParams = json_encode($parms, true);

        $pixel = new \App\Http\Controllers\FacebookPixelController();

        $pixel->sendEvent($pixel->completeRegistration, $jsonParams);
    }

     /**
     * Create an event for Search Product to pixel Facebook
     * 
     */
    public function sendEventSearchProduct($searchWord)
    {
        $jsonParams = $this->getParamsProducts($searchWord);

        $pixel = new \App\Http\Controllers\FacebookPixelController();

        $pixel->sendEvent($pixel->search, $jsonParams);
    }
}
