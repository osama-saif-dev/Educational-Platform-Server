<?php

namespace App\Interfaces\Teacher;

use App\Models\Course;

interface CourseInterface
{
    public function createCourse(array $data);
    public function getCourses();
    public function updateCourse(array $data,Course $course);
    public function showCourse(Course $course);
    public function deleteCourse($id);

}
