<?php

namespace Brackets\AdminAuth\Activation\Traits;

use Brackets\AdminAuth\Activation\Notifications\ActivationNotification;

trait CanActivate
{
    /**
     * Get the e-mail address where activation links are sent.
     *
     * @return string
     */
    public function getEmailForActivation(): string
    {
        return $this->email;
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendActivationNotification(string $token): void
    {
        $this->notify(app(ActivationNotification::class, ['token' => $token]));
    }
}
