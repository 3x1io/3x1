<?php

namespace Brackets\Translatable\Providers;

use Brackets\Translatable\Translatable;
use Illuminate\Support\ServiceProvider;

class TranslatableProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('translatable', Translatable::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['translatable'];
    }
}
