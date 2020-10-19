<?php

namespace App\Events\Landing\Cart;

use Illuminate\Queue\SerializesModels;

class CartHit
{
    use SerializesModels;

    const CREATED = 'cart.created';

    const UPDATED = 'cart.updated';

    const DELETED = 'cart.deleted';

    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
