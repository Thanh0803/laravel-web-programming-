<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DivisionnotypeCollection extends ResourceCollection
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
                    'lop_id' =>$divison->lop_id,            
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
