<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class CoursesDetailesRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return
        [
            'course_id'     => 'required|exists:courses,id',
            'title'         => 'required',
            'desc'          => 'required',
            'video'         => 'required|url',
        ];
    }
}
