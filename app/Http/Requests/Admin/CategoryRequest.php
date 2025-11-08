<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        $categoryId = $this->route('category')?->id;

        return
            [

                'name' =>
                [
                    'required',
                    Rule::unique('categories', 'name')
                        ->where('admin_id', auth()->id()) // التحقق عند نفس المدرس فقط
                        ->ignore($categoryId), // تجاهل السجل الحالي عند التعديل
                ],
                // 'admin_id'  => 'required|exists:users,id',
            ];
    }
}
