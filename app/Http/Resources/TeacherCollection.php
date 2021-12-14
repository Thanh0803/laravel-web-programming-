<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TeacherCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($teacher){
                return [
                    'id' => $teacher->id,
                    'fullname' => $teacher->fullname,
                    'phone' => $teacher->phone,
                    'email' =>  $teacher->email,
                    'gender' =>  $teacher->gender,
                    // 'created_at' => (string) $this->created_at,
                    'level' => $teacher->level
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
