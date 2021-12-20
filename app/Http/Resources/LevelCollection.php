<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LevelCollection extends ResourceCollection
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
            'data' => $this->collection->map(function ($level){
                return [
                    'id' => $level->id,
                    'teacher' => new TeacherResource($level->teacher),
                    'subject_id' => $level->subject_id,
                ];
            }),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
