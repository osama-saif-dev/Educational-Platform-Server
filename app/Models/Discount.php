<?php

namespace App\Models;

use App\Models\User;
use App\Models\Scopes\TeacherScope;
use App\Models\Scopes\TeacherAuthScope;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table    = 'discounts';
    protected $guarded  = [];


    public function Teacher()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }


    protected static function booted()
    {
       static::addGlobalScope(new TeacherScope);
    //    static::addGlobalScope(new TeacherAuthScope);
    }
}
