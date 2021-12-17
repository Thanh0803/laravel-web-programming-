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
                    'lop_id' =>$assign->lop_id,
                    'subject_id' => $assign->subject_id,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
