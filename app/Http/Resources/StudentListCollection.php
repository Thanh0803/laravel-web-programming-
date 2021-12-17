<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StudentListCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($student){
                return [
                    'id' => $student->id,
                    'fullname' => $student->fullname,
                    'phone' => $student->phone,
                    'email' =>  $student->email,
                    'gender' =>  $student->gender,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];

    }
}
