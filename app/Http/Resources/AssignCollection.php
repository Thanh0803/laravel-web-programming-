<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\TeacherResource;

class AssignCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($assign){
                return [
                    'id' => $assign->id,
                    'teacher' => new TeacherResource($assign->teacher),
                    'lop' =>$assign->lop,
                    'schoolYear' =>$assign->lop->schoolYear,
                    'subject' => $assign->subject,
                    'semester' => $assign->semester,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
