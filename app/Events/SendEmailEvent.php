<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendEmailEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $from;
    public $to;
    public $subject;
    public $body;

    /**
     * Create a new event instance.
     *
     * @param string $from The message sender
     * @param string $to The recipient of the message
     * @param string $subject The subject of the message
     * @param string $body The body of the message
     */
    public function __construct($from, $to, $subject, $body)
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
    }

}
