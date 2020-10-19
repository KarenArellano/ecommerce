<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Cart;

class AbandonedCartMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Cart instance
     *
     * @var \App\Models\Customer\Cart
     */
    public $cart;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('landing.cart.abandoned', compact($this->cart))
        ->subject(trans('abandoned.subject'))
        ->priority(1);
    }
}
