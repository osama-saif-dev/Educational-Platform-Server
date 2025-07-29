<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return
        [
            'name'      => 'required|unique:categories,name,'.$this->id,
            'admin_id'  => 'required|exists:users,id',
        ];
    }
}
