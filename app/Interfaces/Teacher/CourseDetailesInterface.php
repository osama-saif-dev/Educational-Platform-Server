<?php

namespace App\Interfaces\Teacher;

interface CourseDetailesInterface
{
    public function createCourseDetailes(array $data);
    // public function getCourseDetailess();
    public function updateCourseDetailes(array $data,$id);
    public function showCourseDetailes($id);
    public function deleteCourseDetailes($id);
}
