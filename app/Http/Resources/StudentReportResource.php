<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class StudentReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request),[
                'class_average' =>  $this->subjectStat()->average,
                'subject_total' => $this->totalScore(),
                'subject_position' => $this->subjectPosition(),
        ]);
    }
}
