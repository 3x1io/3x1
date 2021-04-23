<?php

namespace Brackets\AdminListing\Tests;

use Brackets\AdminListing\AdminListing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Orchestra\Testbench\TestCase as Test;

abstract class TestCase extends Test
{

    /**
     * @var Model
     */
    protected $testModel;

    /**
     * @var AdminListing
     */
    protected $listing;

    /**
     * @var AdminListing
     */
    protected $translatedListing;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpDatabase($this->app);
        $this->listing = AdminListing::create(TestModel::class);
        $this->translatedListing = AdminListing::create(TestTranslatableModel::class);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'pgsql');
        $app['config']->set('database.connections.pgsql', [
            'driver' => 'pgsql',
            'host' => '127.0.0.1',
            'port' => env('DOCKER_PGSQL_TEST_PORT', '5555'),
            'database' => 'testing',
            'username' => 'testing',
            'password' => 'secret',
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ]);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        /** @var Builder $schema */
        $schema = $app['db']->connection()->getSchemaBuilder();
        $schema->dropIfExists('test_models');
        $schema->create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('color');
            $table->integer('number');
            $table->dateTime('published_at');
        });

        TestModel::create([
            'name' => 'Alpha',
            'color' => 'red',
            'number' => 999,
            'published_at' => '2000-06-01 00:00:00',
        ]);

        collect(range(2, 10))->each(function ($i) {
            TestModel::create([
                'name' => 'Zeta '.$i,
                'color' => 'yellow',
                'number' => $i,
                'published_at' => (1998+$i).'-01-01 00:00:00',
            ]);
        });

        $schema->dropIfExists('test_translatable_models');
        $schema->create('test_translatable_models', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->dateTime('published_at');
            $table->jsonb('name')->nullable();
            $table->jsonb('color')->nullable();
        });

        TestTranslatableModel::create([
            'name' => [
                'en' => 'Alpha',
                'sk' => 'Alfa',
            ],
            'color' => [
                'en' => 'red',
                'sk' => 'cervena',
            ],
            'number' => 999,
            'published_at' => '2000-06-01 00:00:00',
        ]);

        collect(range(2, 10))->each(function ($i) {
            TestTranslatableModel::create([
                'name' => [
                    'en' => 'Zeta '.$i,
                ],
                'color' => [
                    'en' => 'yellow',
                ],
                'number' => $i,
                'published_at' => (1998+$i).'-01-01 00:00:00',
            ]);
        });
    }
}
