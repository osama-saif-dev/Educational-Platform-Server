<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\Teacher\CourseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseDetailesResource extends JsonResource
{
   
    public function toArray(Request $request): array
    {
        return
        [
            'id'            => $this->id,
            'title'         => $this->title ?? '',
            'desc'          => $this->desc ?? '',
            'course_id'     => $this->course_id ?? '',
            'video'         => $this->video ?? '',
            'views_count'   => $this->views_count ?? '0',
            'rate'          => $this->rate ?? '0',
            'created_at'    => $this->created_at ?? '',

            'course' => new CourseResource($this->whenLoaded('course')),

        ];
    }
}
