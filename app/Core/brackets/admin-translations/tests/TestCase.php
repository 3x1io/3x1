<?php

namespace Brackets\AdminTranslations\Test;

use Brackets\AdminAuth\AdminAuthServiceProvider;
use Brackets\AdminTranslations\AdminTranslationsServiceProvider;
use Brackets\AdminTranslations\Test\Exceptions\Handler;
use Brackets\AdminTranslations\Translation;
use Brackets\Translatable\TranslatableServiceProvider;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    use RefreshDatabase;

    /** @var \Brackets\AdminTranslations\Translation */
    protected $languageLine;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');

        include_once __DIR__.'/../database/migrations/create_translations_table.php.stub';

        (new \CreateTranslationsTable())->up();

        $this->languageLine = $this->createTranslation('*', 'group', 'key', ['en' => 'english', 'nl' => 'nederlands']);

        File::copyDirectory(__DIR__.'/fixtures/resources/views', resource_path('views'));
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            TranslatableServiceProvider::class,
            AdminTranslationsServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['path.lang'] = $this->getFixturesDirectory('lang');

        $app['config']->set('translatable.locales', ['en', 'sk']);

        if (env('DB_CONNECTION') === 'pgsql') {
            $app['config']->set('database.default', 'pgsql');
            $app['config']->set('database.connections.pgsql', [
                'driver' => 'pgsql',
                'host' => 'testing',
                'port' => '5432',
                'database' => env('DB_DATABASE', 'laravel'),
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', 'bestsecret'),
                'charset' => 'utf8',
                'prefix' => '',
                'schema' => 'public',
                'sslmode' => 'prefer',
            ]);
        } else {
            $app['config']->set('database.default', 'sqlite');
            $app['config']->set('database.connections.sqlite', [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ]);
        }

        $app['config']->set('admin-translations.model', Translation::class);

        $app['config']->set('admin-translations.scanned_directories', [__DIR__.'/fixtures/views']);

        $app['config']->set('app.key', '6rE9Nz59bGRbeMATftriyQjrpF7DcOQm');
    }

    public function getFixturesDirectory(string $path): string
    {
        return __DIR__."/fixtures/{$path}";
    }

    //TODO reorder
    protected function createTranslation(string $namespace, string $group, string $key, array $text): Translation
    {
        return Translation::create(compact('group', 'key', 'namespace', 'text'));
    }

    public function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct()
            {
            }

            public function report(Exception $e)
            {
                // no-op
            }

            public function render($request, Exception $e)
            {
                throw $e;
            }
        });
    }
}
