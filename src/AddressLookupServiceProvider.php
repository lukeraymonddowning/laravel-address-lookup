<?php

namespace Lukeraymonddowning\PostcodeLookup;

use Illuminate\Support\ServiceProvider;
use Lukeraymonddowning\PostcodeLookup\Drivers\AddressLookup;
use Lukeraymonddowning\PostcodeLookup\Drivers\NullAddressLookup;

class AddressLookupServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../config/config.php' => config_path('postcode-lookup.php'),
                ],
                'config'
            );
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'postcode-lookup');

        $this->app->singleton(
            AddressLookup::class,
            function ($app) {
                $activeDriver = config('postcode-lookup.default');

                return $activeDriver
                    ? app(config("postcode-lookup.drivers.$activeDriver.class"))
                    : app(NullAddressLookup::class);
            }
        );
    }
}
