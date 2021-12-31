<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->morning && $this->afternoon){
            $presence = 'Present';
        }else if($this->morning && !$this->afternoon){
            $presence = 'Morning only';
        }else if(!$this->morning && $this->afternoon){
            $presence = 'Afternoon only';
        }else if(!$this->morning && !$this->afternoon){
            $presence = 'Absent';
        }else{
            $presence = '';
        }
        
        return [
            'title' => $presence,
            'start' => $this->date,
            'end' => $this->date
        ];
    }
}
