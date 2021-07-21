<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $view;
    public $data;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $view="welcome", $data=[])
    {
        $this->view = $view;
        $this->data = $data;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->view, $this->data)
            ->subject($this->subject);
    }
}
