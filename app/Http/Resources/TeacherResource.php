<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AccountResource;

class TeacherResource extends JsonResource

{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'account' => new AccountResource($this->account),
            'email'=>$this->account->email,
            'username'=>$this->account->username,
            'fullname' =>  $this->fullname,
            'phone' => $this->phone,
            // 'email' =>  $this->email,
            'gender' =>  $this->gender,
            'created_at' => (string) $this->created_at,
            'level' => $this->level,
        ];
    }
}

