<?php

namespace Brackets\AdminAuth\Activation\Contracts;

interface CanActivate
{
    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForActivation(): string;

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendActivationNotification(string $token): void;
}
