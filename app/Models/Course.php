<?php

namespace App\Models;

use App\Models\User;
use App\Models\Discount;
use App\Models\Scopes\TeacherScope;
use App\Models\Scopes\UserAuthScope;
use App\Models\Scopes\TeacherAuthScope;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table    = 'courses';
    protected $guarded  = [];


    public function Teacher()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class,'copon_id');
    }


    protected static function booted()
    {
       static::addGlobalScope(new TeacherScope);
    }
}
