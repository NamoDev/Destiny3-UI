<?php

namespace App\Providers;

use App\RESTResponse\RESTResponse;
use Illuminate\Support\ServiceProvider;

class RESTResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('RESTResponse', function(){
            return new RESTResponse;
        });
    }
}
