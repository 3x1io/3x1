<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PushNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $title;
    public $message;
    public $icon;
    public $url;
    public $image;
    public $type;
    public $authId;

    public function __construct($title, $message, $icon, $image, $url,$type, $authId)
    {
        $this->title = $title;
        $this->message  = $message;
        $this->icon  = $icon;
        $this->url  = $url;
        $this->image  = $image;
        $this->type  = $type;
        $this->authId  = $authId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['push-notifications'];
    }

}
