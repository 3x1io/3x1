<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Facebook\Components\Button;
use NotificationChannels\Facebook\FacebookChannel;
use NotificationChannels\Facebook\FacebookMessage;

class Facebook extends Notification
{
    use Queueable;

    private $message;
    private $user_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $user_id)
    {
        $this->message = $message;
        $this->user_id = $user_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FacebookChannel::class];
    }

    public function toFacebook($notifiable)
    {
        return FacebookMessage::create($this->message)
            ->to($this->user_id);
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
