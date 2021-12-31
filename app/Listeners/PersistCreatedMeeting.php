<?php

namespace App\Listeners;

use App\Models\EClass;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class PersistCreatedMeeting implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $e_class = new EClass();
        $e_class->zoom_uuid = $event->response['uuid'];
        $e_class->zoom_meeting_id = $event->response['id'];
        $e_class->topic = $event->response['topic'];
        $e_class->type = $event->response['type'];
        $e_class->duration = $event->response['duration'];
        $e_class->start_url = $event->response['start_url'];
        $e_class->join_url = $event->response['join_url'];
        $e_class->password = $event->response['password'];
        $e_class->start_time = $event->response['start_time'];
        $e_class->section_id = $event->section_id;
        
        $e_class->save();
    }
}
