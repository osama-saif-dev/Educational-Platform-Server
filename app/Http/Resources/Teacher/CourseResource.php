<?php

namespace App\Http\Resources\Teacher;

use Illuminate\Http\Request;
use App\Http\Resources\CourseDetailesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
        [
            'id'            => $this->id,
            'title'         => $this->title ?? '',
            'price'         => $this->price ?? '',
            'teacher_id'    => $this->teacher_id ?? '',
            'desc'          => $this->desc ?? '',
            'video'         => $this->video ?? '',
            'views'         => $this->views ?? '0',
            'created_at'    => $this->created_at ?? '',
            'course_detailes' => CourseDetailesResource::collection($this->whenLoaded('course_detailes')),

        ];
    }
}
