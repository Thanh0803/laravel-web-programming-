<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MarkCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($type){
                return [
                    'id' => $type->id,
                    'fif' => $type->fifs,
                    'fort' => $type->forts,
                    'nine' => $type->nines,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
