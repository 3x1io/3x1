<?php

namespace Brackets\AdminAuth\Activation\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Brackets\AdminAuth\Activation\Brokers\ActivationBrokerManager
 */
class Activation extends Facade
{
    /**
     * Constant representing a successfully sent reminder.
     *
     * @var string
     */
    public const ACTIVATION_LINK_SENT = 'sent';

    /**
     * Constant representing a successfully reset password.
     *
     * @var string
     */
    public const ACTIVATED = 'activated';

    /**
     * Constant representing the user not found response.
     *
     * @var string
     */
    public const INVALID_USER = 'invalid-user';

    /**
     * Constant representing an invalid token.
     *
     * @var string
     */
    public const INVALID_TOKEN = 'invalid-token';

    /**
     * Constant representing a disabled activation.
     *
     * @var string
     */
    public const ACTIVATION_DISABLED = 'disabled';

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'auth.activation';
    }
}
