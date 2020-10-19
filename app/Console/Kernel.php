<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\AbandonedCartCommand',
        'App\Console\Commands\AbandonedCartDayCommand',
        'App\Console\Commands\AbandonedCartWeekCommand'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        if (App::isProduction()) 
        {
            $schedule->command('cart-hour-reminder')->hourly();
            $schedule->command('cart-day-reminder')->dailyAt('15:00');
            $schedule->command('cart-week-reminder')->dailyAt('15:00');
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
