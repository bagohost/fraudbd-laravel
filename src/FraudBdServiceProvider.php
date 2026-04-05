<?php

namespace FraudBd\Laravel;

use Illuminate\Support\ServiceProvider;

class FraudBdServiceProvider extends ServiceProvider
{
    public function register()
    {
       
        $this->mergeConfigFrom(__DIR__.'/../config/fraudbd.php', 'fraudbd');

        
        $this->app->singleton('fraudbd', function ($app) {
            return new FraudBd();
        });
    }

    public function boot()
    {
        
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/fraudbd.php' => config_path('fraudbd.php'),
            ], 'fraudbd-config');
        }
    }
}