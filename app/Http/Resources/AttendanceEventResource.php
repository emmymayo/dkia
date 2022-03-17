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
        $color = '';
        if($this->morning && $this->afternoon){
            $presence = 'Present';
            $color = 'green';
        }else if($this->morning && !$this->afternoon){
            $presence = 'Morning only';
            $color = 'blue';
        }else if(!$this->morning && $this->afternoon){
            $presence = 'Afternoon only';
            $color = 'blue';
        }else if(!$this->morning && !$this->afternoon){
            $presence = 'Absent';
            $color = 'yellow';
        }else{
            $presence = '';
        }
        
        return [
            'id' => $this->id,
            'title' => $presence.' '.$this->remark,
            'start' => $this->date,
            'end' => $this->date,
            'color' => $color
        ];
    }
}
