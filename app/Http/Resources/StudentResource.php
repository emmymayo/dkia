<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'admin_no' => $this->admin_no,
            'year_admitted' => $this->year_admitted,
            'graduated' => $this->graduated,
            'gender' => $this->gender,
            'dob' => $this->dob,
            'state_id' => $this->state_id,
            'lga_id' => $this->lga_id,
            'address' => $this->address,
            'guardian_email' => $this->guardian_email,
            'phone1' => $this->phone1,
            'phone2' => $this->phone2,
            'created_at' => $this->created_at,
            'name' => $this->user->name,
            'avatar' => $this->user->avatar,
            'email' => $this->user->email,
            'status' => $this->user->status,
            'state' => $this->state,
            'lga' => $this->lga,
            'user'=> $this->user
        ];
    }
}
