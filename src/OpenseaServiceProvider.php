<?php

namespace Antikode\Opensea;

use Illuminate\Support\ServiceProvider;

class OpenseaServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/opensea.php' => config_path('opensea.php')
        ]);
    }

    public function register()
    {
        $this->app->singleton(Opensea::class, function() {
            return new Opensea();
        });
    }
}
