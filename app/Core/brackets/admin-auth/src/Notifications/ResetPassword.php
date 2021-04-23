<?php

namespace Brackets\AdminAuth\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param string $token
     * @return void
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable
     * @return array|string
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        //TODO change to template?
        return (new MailMessage)
            ->line(trans('brackets/admin-auth::resets.email.line'))
            ->action(trans('brackets/admin-auth::resets.email.action'), route('brackets/admin-auth::admin/password/showResetForm', $this->token))
            ->line(trans('brackets/admin-auth::resets.email.notRequested'));
    }
}
