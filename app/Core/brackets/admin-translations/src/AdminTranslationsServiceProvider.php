<?php

namespace Brackets\AdminTranslations;

use Brackets\AdminTranslations\Console\Commands\AdminTranslationsInstall;
use Brackets\AdminTranslations\Console\Commands\ScanAndSave;
use Brackets\AdminTranslations\Providers\TranslationServiceProvider;
use Brackets\AdminUI\AdminUIServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AdminTranslationsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            ScanAndSave::class,
            AdminTranslationsInstall::class,
        ]);

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'brackets/admin-translations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'brackets/admin-translations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/admin-translations.php' => config_path('admin-translations.php'),
            ], 'config');

            if (!glob(base_path('database/migrations/*_create_translations_table.php'))) {
                $timestamp = date('Y_m_d_His');
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_translations_table.php.stub' => database_path('migrations') . '/' . $timestamp . '_create_translations_table.php',
                ], 'migrations');
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/admin-translations.php', 'admin-translations');

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

        if (config('admin-translations.use_routes', true)) {
            if (app(Router::class)->hasMiddlewareGroup('admin')) {
                Route::middleware(['web', 'admin'])
                    ->group(__DIR__ . '/../routes/web.php');
            } else {
                Route::middleware(['web'])
                    ->group(__DIR__ . '/../routes/web.php');
            }
        }

        $this->app->register(TranslationServiceProvider::class);

        // provider auto-discovery has limits - in tests we have to explicitly register providers
        if ($this->app->environment() == 'testing') {
            $this->app->register(AdminUIServiceProvider::class);
        }
    }
}
