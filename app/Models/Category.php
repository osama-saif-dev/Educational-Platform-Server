<?php

namespace App\Models;

use App\Models\User;
use App\Models\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table       = 'categories';
    protected $guarded      = [];

     protected static function booted()
    {
    //    static::addGlobalScope(new AdminScope);
    }


    public function teacher()
    {
        return $this->belongsTo(User::class,'admin_id')->where('role','teacher');
    }

}
