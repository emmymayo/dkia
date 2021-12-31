<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MeetingCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $response;
    public $section_id;

    /**
     * Create a new event instance.
     * @param collection $data 
     *
     * @return void
     */
    public function __construct($zoom_response, $section_id)
    {
        $this->response = $zoom_response;
        $this->section_id = $section_id;
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
