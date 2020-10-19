<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cart;
use Illuminate\Support\Facades\Mail;
use App\Mail\AbandonedCartMail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AbandonedCartDayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart-day-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify the user abandoned cart by past 3 days';

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
        $date = Carbon::now()->subDays(3);

        Log::debug("Three Days");

        Log::debug($date);

        $carts = Cart::where('created_at', '<', $date)->with('user')->where('was_reminded_day', false);

        Log::debug(json_encode($carts)); 
 
        $carts->each(function ($cart) {

            $cart->update(["was_reminded_day" => true]);
            
             Mail::to($cart->user->email)->send(new AbandonedCartMail($cart));

        });
    }
}
