<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\StudentResource;
use App\Http\Resources\TypeResource;

class DivisionCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($divison){
                return [
                    'id' => $divison->id,
                    'student' => new StudentResource($divison->student),
                    'lop' =>$divison->lop,
                    'type' => $divison->types,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
