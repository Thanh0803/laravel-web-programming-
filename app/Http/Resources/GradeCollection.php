<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;


class GradeCollection extends ResourceCollection
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
        'data' => $this->collection->map(function ($grade){
            return [
                'id' => $grade->id,
                'gradeName' => $grade->gradeName,
                'grade' =>$grade->grade,
                'lop' => $grade->lops,
            ];
        }),
        'links' => [
            'self' => 'link-value',
        ],
    ];
}
}