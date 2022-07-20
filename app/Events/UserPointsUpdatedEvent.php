<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPointsUpdatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $value;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

}
