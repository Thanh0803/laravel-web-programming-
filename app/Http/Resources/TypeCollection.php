<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\StudentResource;
use App\Http\Resources\FifResource;
use App\Http\Resources\FortResource;
use App\Http\Resources\NineResource;

class TypeCollection extends ResourceCollection
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
                    'student' => $type->division->student,
                    'subject' => $type->subject,
                    'semester' => $type->semester,
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
