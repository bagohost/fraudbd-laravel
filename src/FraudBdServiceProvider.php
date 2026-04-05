<?php

namespace FraudBd\Laravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'fraudbd');

        
        Route::post('/fraudbd/ajax-check', function (\Illuminate\Http\Request $request) {
            $result = \FraudBd\Laravel\Facades\FraudBd::verifyFraudScore($request->phone);
            return response()->json($result);
        })->name('fraudbd.ajax.check');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/fraudbd.php' => config_path('fraudbd.php'),
            ], 'fraudbd-config');

           
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/fraudbd'),
            ], 'fraudbd-views');
        }
    }
}