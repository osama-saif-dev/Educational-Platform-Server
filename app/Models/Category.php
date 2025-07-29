<?php

namespace App\Models;

use App\Models\Scopes\AdminScope;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table       = 'categories';
    protected $guarded      = [];

     protected static function booted()
    {
       static::addGlobalScope(new AdminScope);
    }

}
