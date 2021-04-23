<?php

namespace Brackets\AdminAuth\Activation\Providers;

use Brackets\AdminAuth\Activation\Brokers\ActivationBrokerManager;
use Brackets\AdminAuth\Activation\Facades\Activation;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class ActivationServiceProvider extends ServiceProvider
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
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../../install-stubs/config/activation.php' => config_path('activation.php'),
            ], 'config');

            if (!glob(base_path('database/migrations/*_create_activations_table.php'))) {
                $this->publishes([
                    __DIR__ . '/../../../install-stubs/database/migrations/create_activations_table.php' => database_path('migrations') . '/2017_08_24_000000_create_activations_table.php',
                ], 'migrations');
            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../../install-stubs/config/activation.php',
            'activation'
        );

        $this->registerActivationBroker();

        $loader = AliasLoader::getInstance();
        $loader->alias('Activation', Activation::class);
    }

    /**
     * Register the password broker instance.
     *
     * @return void
     */
    protected function registerActivationBroker()
    {
        $this->app->singleton('auth.activation', function ($app) {
            return new ActivationBrokerManager($app);
        });

        $this->app->bind('auth.activation.broker', function ($app) {
            return $app->make('auth.activation')->broker();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['auth.activation', 'auth.activation.broker'];
    }
}
