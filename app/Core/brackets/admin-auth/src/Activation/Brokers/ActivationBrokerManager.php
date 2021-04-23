<?php

namespace Brackets\AdminAuth\Activation\Brokers;

use Brackets\AdminAuth\Activation\Contracts\ActivationBroker as ActivationBrokerContract;
use Brackets\AdminAuth\Activation\Contracts\ActivationBrokerFactory as FactoryContract;
use Brackets\AdminAuth\Activation\Repositories\DatabaseTokenRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use InvalidArgumentException;

class ActivationBrokerManager implements FactoryContract
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * The array of created "drivers".
     *
     * @var array
     */
    protected $brokers = [];

    /**
     * Create a new ActivationBroker manager instance.
     *
     * @param Application $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Attempt to get the broker from the local cache.
     *
     * @param string $name
     * @return ActivationBrokerContract
     */
    public function broker($name = null): ?ActivationBrokerContract
    {
        $name = $name ?: $this->getDefaultDriver();

        return $this->brokers[$name] ?? $this->brokers[$name] = $this->resolve($name);
    }

    /**
     * Resolve the given broker.
     *
     * @param string $name
     * @throws \InvalidArgumentException
     * @return ActivationBrokerContract
     */
    protected function resolve($name): ActivationBrokerContract
    {
        $config = $this->getConfig($name);

        if ($config === null) {
            throw new InvalidArgumentException("Activationer [{$name}] is not defined.");
        }

        // The password broker uses a token repository to validate tokens and send user
        // password e-mails, as well as validating that password reset process as an
        // aggregate service of sorts providing a convenient interface for resets.
        return new ActivationBroker(
            $this->createTokenRepository($config),
            $this->app['auth']->createUserProvider($config['provider'])
        );
    }

    /**
     * Create a token repository instance based on the given configuration.
     *
     * @param array $config
     * @return DatabaseTokenRepository
     */
    protected function createTokenRepository(array $config): DatabaseTokenRepository
    {
        $key = $this->app['config']['app.key'];

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        $connection = $config['connection'] ?? null;

        return new DatabaseTokenRepository(
            $this->app['db']->connection($connection),
            $this->app['hash'],
            $config['table'],
            $key,
            $config['expire']
        );
    }

    /**
     * Get the activation broker configuration.
     *
     * @param string $name
     * @return array
     */
    protected function getConfig($name): array
    {
        return $this->app['config']["activation.activations.{$name}"];
    }

    /**
     * Get the default activation broker name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return $this->app['config']['activation.defaults.activations'];
    }

    /**
     * Set the default activation broker name.
     *
     * @param string $name
     * @return void
     */
    public function setDefaultDriver($name): void
    {
        $this->app['config']['activation.defaults.activations'] = $name;
    }

    /**
     * Dynamically call the default driver instance.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->broker()->{$method}(...$parameters);
    }
}
