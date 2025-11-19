<?php

namespace App\Services\Teacher;

use App\Interfaces\Teacher\CourseInterface;
use App\Models\Category;
use App\Models\Course;

class CourseService implements CourseInterface
{
    private $teacher;


    public function __construct()
    {
        $this->teacher = auth()->user();
    }



    public function createCourse(array $data)
    {
        if ($this->teacher->count() == 0) {
            return false;
        }
        $data['teacher_id'] = $this->teacher->id;

        $course             = Course::create($data);
        return $course;
    }




    public function getCourses($search = null)
    {
        $allowedSorts = ['created_at', 'updated_at'];

        // خذ القيم من query string لو موجودة
        $sortBy     = in_array(request('sortBy'), $allowedSorts) ? request('sortBy') : 'created_at';
        $sortDir    = request('sortDir') == 'asc' ? 'asc' : 'desc';

        $couses     = Course::where('teacher_id', $this->teacher->id)
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate(5);

        return $couses;
    }






    public function updateCourse(array $data, Course $course)
    {


        if (!$course) {
            return false;
        }

        $data['teacher_id'] = $this->teacher->id;
        $course             = Course::where('id', $course->id)->where('teacher_id', $this->teacher->id)->first();

        $course->update($data);
        return $course;
    }






    public function showCourse(Course $course)
    {

        if (!$course) {
            return false;
        }
        $course = Course::where('id', $course->id)->where('teacher_id', $this->teacher->id)->with('teacher', 'course_detailes')->first();

        return $course;
    }



    public function deleteCourse($id) {}
}
