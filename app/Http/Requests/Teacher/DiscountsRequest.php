<?php

namespace App\Http\Requests\Teacher;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class DiscountsRequest extends FormRequest
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
            'name' =>
            [
                'required',
                Rule::unique('discounts')->where(function ($query)
                {
                    return $query->where('teacher_id', auth()->id())
                    ->where('end_date', '>=', Carbon::now()->toDateString());
                })->ignore($this->id) // ✅ هذا هو المعرف الصحيح للسجل الحالي,
            ],
            'start_date'    => 'required|date',
            'end_date'      => 'required|date|after:start_date',
            'amount'        => 'required|numeric|gt:0'
        ];
    }
}
