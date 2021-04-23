<?php

namespace Brackets\AdminListing;

use Brackets\AdminListing\Console\Commands\AdminListingInstall;
use Brackets\AdminListing\Facades\AdminListing as AdminListingFacade;
use Illuminate\Support\ServiceProvider;

class AdminListingServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            AdminListingInstall::class,
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('admin-listing', AdminListing::class);

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('AdminListing', AdminListingFacade::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['admin-listing'];
    }
}
