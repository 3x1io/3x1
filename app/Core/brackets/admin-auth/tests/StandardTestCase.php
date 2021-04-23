<?php

namespace Brackets\AdminAuth\Tests;

abstract class StandardTestCase extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->app['config']->set('admin-auth.defaults.guard', 'web');
        $this->app['config']->set('admin-auth.defaults.passwords', 'users');
        $this->app['config']->set('admin-auth.defaults.activations', 'users');
        $this->app['config']->set('admin-auth.check_forbidden', false);
        $this->app['config']->set('admin-auth.activation_enabled', false);
        $this->adminAuthGuard = config('admin-auth.defaults.guard');
    }
}
