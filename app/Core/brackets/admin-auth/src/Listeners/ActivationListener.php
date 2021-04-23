<?php

namespace Brackets\AdminAuth\Listeners;

use Brackets\AdminAuth\Activation\Contracts\CanActivate;
use Brackets\AdminAuth\Activation\Facades\Activation;
use Brackets\AdminAuth\Services\ActivationService;
use Illuminate\Events\Dispatcher;

class ActivationListener
{
    /**
     * Activation broker used for admin user
     *
     * @var string
     */
    protected $activationBroker = 'admin_users';

    /**
     * Create a new ActivationListener
     *
     * @return void
     */
    public function __construct()
    {
        $this->activationBroker = config('admin-auth.defaults.activations');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $activationBrokerConfig = config("activation.activations.{$this->activationBroker}");
        if (app('auth')->createUserProvider($activationBrokerConfig['provider']) !== null) {
            $userClass = Activation::broker($this->activationBroker)->getUserModelClass();
            $interfaces = class_implements($userClass);
            if ($interfaces && in_array(CanActivate::class, $interfaces, true)) {
                $events->listen(
                    'eloquent.created: ' . $userClass,
                    ActivationService::class
                );
            }

            //TODO listen on user edit and if email has changed, deactivate user and send email again
        }
    }
}
