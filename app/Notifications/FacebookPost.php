<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\FacebookPoster\FacebookPosterChannel;
use NotificationChannels\FacebookPoster\FacebookPosterPost;

class FacebookPost extends Notification
{
    use Queueable;

    private $post;
    private $image;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post, $image="")
    {
        $this->post = $post;
        $this->image = $image;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FacebookPosterChannel::class];
    }

    /**
     * Get the Facebook post representation of the notification.
     *
     * @param  mixed  $notifiable.
     * @return \NotificationChannels\FacebookPoster\FacebookPosterPost
     */
    public function toFacebookPoster($notifiable) {
        if(!empty($this->image)){
            return (new FacebookPosterPost($this->post))
                ->withImage(url($this->image));
        }
        else {
            return (new FacebookPosterPost($this->post));
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
