<?php

namespace Brackets\AdminAuth\Activation\Contracts;

use Closure;

interface ActivationBroker
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
     * Send activation link to a user.
     *
     * @param array $credentials
     * @return string
     */
    public function sendActivationLink(array $credentials): string;

    /**
     * Activate user for the given token.
     *
     * @param array $credentials
     * @param Closure $callback
     * @return mixed
     */
    public function activate(array $credentials, Closure $callback);
}
