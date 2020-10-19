<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;
use App\Mail\AbandonedCartMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AbandonedCartWeekCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart-week-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify the user abandoned cart by past 1 week';

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
        $date = Carbon::now()->subWeek();

        Log::debug("OneWeek");
        
        Log::debug($date);

        $carts = Cart::where('created_at', '<', $date)->with('user')->where('was_reminded_week', false);

        Log::debug(json_encode($carts)); 
 
        $carts->each(function ($cart) {

            $cart->update(["was_reminded_week" => true]);
            
             Mail::to($cart->user->email)->send(new AbandonedCartMail($cart));

        });
    }
}
