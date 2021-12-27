<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ConductdetailCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($division){
                return [
                    'id' => $division->id,
                    'mark' => $division->student->conduct->mark,
                    'comment' => $division->student->conduct->comment,
                    'semester' =>  $division->student->conduct->semester,
                    'schoolYear' =>  $division->student->conduct->schoolYear,
                    'fullname' => $division->student->fullname,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
