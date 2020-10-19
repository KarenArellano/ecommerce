<?php

namespace App\Console\Commands;
use App\Models\Cart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\AbandonedCartMail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class AbandonedCartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart-hour-reminder';

    protected $name = 'cart-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify the user abandoned cart by hours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $date = Carbon::now()->subHours(6);

        Log::debug("6 Hours");

        Log::debug($date);
        
        $carts = Cart::where('created_at', '<', $date)->with('user')->where('was_reminded_hour', false)->get();

        Log::debug(json_encode($carts)); 
 
        $carts->each(function ($cart) {
            
            $cart->update(["was_reminded_hour" => true]);

             Mail::to($cart->user->email)->send(new AbandonedCartMail($cart));

        });
            
    } 

    public function fire()
    {
        $this->handle();
    }
}
