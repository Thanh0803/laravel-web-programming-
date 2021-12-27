<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\StudentResource;
use App\Http\Resources\ConductResource;

class ConductCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($division){
                return [
                    'id' => $division->id,
                    'student' => new StudentResource($division->student),
                    'lop_id' => $division->lop_id,
                    'conduct' => $division->student->conduct
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
