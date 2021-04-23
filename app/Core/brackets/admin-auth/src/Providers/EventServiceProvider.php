<?php

namespace Brackets\AdminAuth\Providers;

use Brackets\AdminAuth\Listeners\ActivationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        ActivationListener::class,
    ];
}
