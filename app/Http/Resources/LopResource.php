<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LopResource extends JsonResource
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
            'className' =>$this->className,
            'academicYear'=>$this->academicYear,
            'schoolYear'=>$this->schoolYear,
            'teacher'=>$this->teacher,
            'grade_id'=>$this->grade_id,
            'fullname' =>$this->teacher->fullname,
            // 'headTeacher'=> new TeacherResource($this->teacher->id),
        ];
    }
}
