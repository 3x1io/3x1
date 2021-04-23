<?php

namespace Brackets\AdminAuth\Activation\Contracts;

interface ActivationBrokerFactory
{
    /**
     * Get a password broker instance by name.
     *
     * @param string|null $name
     * @return mixed
     */
    public function broker($name = null);
}
