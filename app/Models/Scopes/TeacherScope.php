<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TeacherScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check() && auth()->user()->role === 'teacher')
        {
            $builder->where('teacher_id', auth()->id());
        }
    }
}
