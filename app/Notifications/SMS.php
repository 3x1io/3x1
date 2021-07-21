<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Messagebird\MessagebirdChannel;
use NotificationChannels\Messagebird\MessagebirdMessage;

class SMS extends Notification
{
    use Queueable;

    private $message;
    private $recipients;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $recipients)
    {
        $this->message = $message;
        $this->recipients = $recipients;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [MessagebirdChannel::class];
    }

    public function toMessagebird($notifiable)
    {
        return (new MessagebirdMessage($this->message))->setRecipients($this->recipients);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
