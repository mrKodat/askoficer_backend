<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendPushNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $title;
    public $message;
    public $questionId;
    public $authorId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId, $title, $message, $questionId, $authorId)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->message = $message;
        $this->questionId = $questionId;
        $this->authorId = $authorId;
    }

}
