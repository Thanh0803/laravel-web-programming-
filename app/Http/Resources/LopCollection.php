<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LopCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'data' => $this->collection->map(function ($lop){
                return [
                    'id' => $lop->id,
                    'className' => $lop->className,
                    // 'teacher_id' => $lop->teacher_id,
                    // 'headTeacher' => $lop->teacher_id->fullname,
                    'schoolYear' =>  $lop->schoolYear,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
