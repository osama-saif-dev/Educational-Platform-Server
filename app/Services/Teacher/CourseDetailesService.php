<?php

namespace App\Services\Teacher;

use App\Models\Course;
use App\Interfaces\Teacher\CourseDetailesInterface;
use App\Models\CourseDetailes;

class CourseDetailesService implements CourseDetailesInterface
{
    private $teacher;


    public function __construct()
    {
        $this->teacher = auth()->user();
    }



    public function createCourseDetailes(array $data)
    {
        $course = Course::find($data['course_id']);

        if ($this->teacher->count() == 0 && $this->teacher->id != $course['teacher_id'])
        {
            return "Can,t Ceate Course Detailes For This Course";
        }

        $courseDetailes             = CourseDetailes::create($data);
        return $courseDetailes;
    }




    // public function getCourseDetailess($search = null)
    // {
    //     // $allowedSorts = ['created_at', 'updated_at'];

    //     // // خذ القيم من query string لو موجودة
    //     // $sortBy     = in_array(request('sortBy'), $allowedSorts) ? request('sortBy') : 'created_at';
    //     // $sortDir    = request('sortDir') == 'asc' ? 'asc' : 'desc';

    //     $couses     = Course::where('course_id', $this->teacher->id)
    //     ->when($search, function ($query) use ($search)
    //     {
    //         $query->where('title', 'like', '%' . $search . '%');
    //     })
    //     ->orderBy($sortBy, $sortDir)
    //     ->paginate(5);

    //     return $couses;
    // }






    public function updateCourseDetailes(array $data, $id)
    {

        $courseDetailes = CourseDetailes::find($id);
        $course         = Course::find($data['course_id']);

        if ($this->teacher->count() == 0 && $this->teacher->id != $course['teacher_id'])
        {
            return "Can,t Ceate Course Detailes For This Course";
        }

        $courseDetailes->update($data);
        return $courseDetailes;
    }






    public function showCourseDetailes($id)
    {
        $courseDetailes = CourseDetailes::where('id', $id)->with('course')->first();


        if (!$courseDetailes)
        {
            return false;
        }

        return $courseDetailes;
    }



    public function deleteCourseDetailes($id) {}
}
