<?php

namespace App\Providers;

use App\Models\Gallery;
use App\Models\Product;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'products' => Product::class,
            'galleries' => Gallery::class,
        ]);

        if (App::isProduction()) 
        {
            URL::forceScheme('https');
        }
    }
}
