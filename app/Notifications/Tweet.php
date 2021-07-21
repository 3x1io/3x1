<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterDirectMessage;
use NotificationChannels\Twitter\TwitterStatusUpdate;

class Tweet extends Notification
{
    use Queueable;

    private $tweet;
    private $message;
    private $username;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tweet, $message=false, $username=null)
    {
        $this->tweet = $tweet;
        $this->message = $message;
        $this->username = $username;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwitterChannel::class];
    }


    public function toTwitter($notifiable)
    {
        if($this->message){
            return new TwitterDirectMessage($this->username, $this->tweet);
        }
        else {
            return new TwitterStatusUpdate($this->tweet);
        }

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
