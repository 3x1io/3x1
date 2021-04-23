<?php

namespace Brackets\Media;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (app(Router::class)->hasMiddlewareGroup('admin')) {
            Route::middleware(['web', 'admin'])
                ->group(__DIR__ . '/../routes/web.php');
        } else {
            Route::middleware(['web'])
                ->group(__DIR__ . '/../routes/web.php');
        }


        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../install-stubs/config/media-collections.php' => config_path('media-collections.php'),
            ], 'config');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //FIXME it would be nice if you could somehow publish into filesystems
        $this->mergeConfigFrom(
            __DIR__ . '/../config/filesystems.php',
            'filesystems.disks'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../install-stubs/config/media-collections.php',
            'media-collections'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/admin-auth.php',
            'admin-auth.defaults'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/auth.guard.admin.php',
            'auth.guards.admin'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../config/auth.providers.admin_users.php',
            'auth.providers.admin_users'
        );
    }
}
