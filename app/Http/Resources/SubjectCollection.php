<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SubjectCollection extends ResourceCollection
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
            // return parent::toArray($request);
            'data' => $this->collection->map(function ($subject){
                return [
                    'id' => $subject->id,
                    'subjectName' => $subject->subjectName,
                    'grade' =>$subject->grade,
                    'subjectWeight' => $subject->subjectWeight,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
