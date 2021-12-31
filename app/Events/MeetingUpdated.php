<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MeetingUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $e_class_id;

    /**
     * Create a new event instance.
     * @param array $data - updated data
     *
     * @return void
     */
    public function __construct(array $data, $e_class_id)
    {
        $this->data = $data;
        $this->e_class_id = $e_class_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
