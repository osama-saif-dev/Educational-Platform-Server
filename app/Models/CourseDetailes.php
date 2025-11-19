<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;

class CourseDetailes extends Model
{
    protected $table    = 'course_detailes';
    protected $fillable =
    [
        'course_id',
        'title',
        'desc',
        'video',
        'views_count',
        'rate',
    ];


    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
