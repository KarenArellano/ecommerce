<?php

namespace App\Http\Controllers\Landing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Landing\ContactFormSent;
use Illuminate\Support\Facades\App;
use App\Concerns\Landing\InteractsWithCoupon;

class ContactController extends Controller
{
    use InteractsWithCoupon;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $first_coupon = $this->getCouponFirstAvailable();

        return view('landing.contact', compact('first_coupon'));
    }

    /**
     * Sends a notification from contact form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendNotificationFromContactForm(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'message' => ['required', 'string'],
        ]);
        
        if (App::isProduction()) 
        {
            Notification::route('mail', 'paola_raya@outlook.com')->notify(
                new ContactFormSent($request)
            );
        }

        return back()->with('status.email.sent', __('Gracias por ponerte en contacto conmigo, en breve, me comunicare contigo'));
    }

    public function sendPixelContact(){

        $pixel = new \App\Http\Controllers\FacebookPixelController();
        
        $pixel->sendEvent($pixel->Contact, null);
    }
}
