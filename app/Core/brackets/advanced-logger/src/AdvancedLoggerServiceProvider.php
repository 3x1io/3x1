<?php

namespace Brackets\AdvancedLogger;

use Brackets\AdvancedLogger\Providers\EventServiceProvider;
use Brackets\AdvancedLogger\Services\Benchmark;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\ServiceProvider;

/**
 * Class AdvancedLoggerServiceProvider
 */
class AdvancedLoggerServiceProvider extends ServiceProvider
{
    use DispatchesJobs;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/advanced-logger.php' => config_path('advanced-logger.php'),
        ], 'config');
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/advanced-logger.php', 'advanced-logger');
        Benchmark::start(config('advanced-logger.request.benchmark', 'application'));
    }
}
