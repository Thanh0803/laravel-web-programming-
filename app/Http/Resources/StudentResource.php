<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AccountResource;

class StudentResource extends JsonResource
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
            'fullname' => $this->fullname,
            'account' => new AccountResource($this->account),
            'email'=>$this->account->email,
            'password' =>$this->account->password,
            'username'=>$this->account->username,
            'phone' => $this->phone,
            'gender' =>  $this->gender,
            'fatherName'=>$this->fatherName,
            'motherName'=>$this->motherName,
            'fatherCareer'=>$this->fatherCareer,
            'motherCareer'=>$this->motherCareer,
            'fatherPhone'=>$this->fatherPhone,
            'motherPhone'=>$this->motherPhone,
            'update_at' => (string) $this->updated_at,
        ];
    }
}
