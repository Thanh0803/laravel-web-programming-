<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ConductStudentCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($conduct){
                return [
                    'id' => $conduct->id,
                    'mark' => $conduct->mark,
                    'comment' => $conduct->comment,
                    'semester' =>  $conduct->semester,
                    'schoolYear' =>  $conduct->schoolYear,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
