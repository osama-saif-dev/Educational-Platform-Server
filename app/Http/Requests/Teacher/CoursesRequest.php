<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class CoursesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return
        [
            'teacher_id'            => 'required|exists:users,id',
            'copon_id'              => 'nullable|exists:discounts,id',
            'title'                 => 'required',
            'desc'                  => 'required',
            'video'                 => 'required|url',
            'price'                 => 'required|numeric|gt:0',
        ];
    }
}
