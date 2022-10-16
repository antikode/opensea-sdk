<?php

namespace Masiting\Opensea;

use Illuminate\Support\ServiceProvider;

class OpenseaServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
    }

    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/opensea.php' => config_path('opensea.php')
        ], 'opensea-config');
    }


    public function register()
    {
        $this->app->singleton(Opensea::class, function() {
            return new Opensea();
        });
    }
}
