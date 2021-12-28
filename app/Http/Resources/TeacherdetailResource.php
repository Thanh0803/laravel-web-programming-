<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherdetailResource extends JsonResource
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
            'id' => $this->teacher->id,
            'account' => new AccountResource($this->teacher->account),
            'email'=>$this->teacher->account->email,
            'username'=>$this->teacher->account->username,
            'fullname' =>  $this->teacher->fullname,
            'phone' => $this->teacher->phone,
            // 'email' =>  $this->email,
            'gender' =>  $this->teacher->gender,
            'created_at' => (string) $this->teacher->created_at,
            'level' => $this->teacher->level,
        ];
    }
}
