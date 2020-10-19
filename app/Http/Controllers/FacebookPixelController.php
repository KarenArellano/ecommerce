<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use WebLAgence\LaravelFacebookPixel\LaravelFacebookPixel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class FacebookPixelController extends Controller
{
    /**
     * LaravelFacebookPixel instance
     *
     * @var @package WebLAgence\LaravelFacebookPixel
     * 
     * https://github.com/weblagence/laravel-facebook-pixel
     */
    protected $laravelFacebookPixel;

    /**
     * All events Names Pixel Facebook
     * https://developers.facebook.com/docs/facebook-pixel/reference#events
     * 
     */
    public $addPaymentInfo = "AddPaymentInfo";
    public $addToCart = "AddToCart";
    public $completeRegistration = "CompleteRegistration";
    public $makeContact = "Contact";
    public $initCheckout = "InitiateCheckout";
    public $registerComplete = "CompleteRegistration";
    public $onPage = "PageView";
    public $endPurchase = "Purchase";
    public $search = "Search";
    public $viewContent = "ViewContent";

    /**
     * Creates a new controller instance
     *
     * @param App\Models\Post $post
     */
    public function __construct()
    {   
        $this->laravelFacebookPixel = new LaravelFacebookPixel(config('facebook-pixel.facebook_pixel_id'));
    }

    /**
     * Send a event to pixel Faceook
     *  @param Facebook Pixel Params
     */
    public function sendEvent($eventName, $params = [])
    {
        if (App::isProduction())
        {
            $this->laravelFacebookPixel->createEvent($eventName, $params);
        }

        Log::info($eventName);
        Log::info($params);
    }
}
