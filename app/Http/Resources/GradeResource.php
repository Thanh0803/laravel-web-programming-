<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LopResource;

class GradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'gradeName' => $this->gradeName,
            'grade' =>$this->grade,
            'lop' => $this->lops,
            // 'lop_id' => $this->lop->id,
            // 'className' =>$this->lop->className,
        ];
    }
}
