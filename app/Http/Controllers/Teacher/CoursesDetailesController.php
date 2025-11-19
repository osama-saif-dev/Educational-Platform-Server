<?php

namespace App\Http\Controllers\Teacher;

use App\Trait\HandleToken;
use Illuminate\Http\Request;
use App\Trait\HandleResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseDetailesResource;
use App\Interfaces\Teacher\CourseDetailesInterface;
use App\Http\Requests\Teacher\CoursesDetailesRequest;

class CoursesDetailesController extends Controller
{
    use HandleResponse, HandleToken;

    public function __construct(private CourseDetailesInterface $courseDetailesService)
    {


    }











    public function store(CoursesDetailesRequest $request)
    {
        $courseDetailes = $this->courseDetailesService->createCourseDetailes($request->validated());
        if(!$courseDetailes)
        {
            return $this->error('exactly one Course Detailes with this name is allowed');
        }
        return $this->success('Course Detailes created successfully', new CourseDetailesResource($courseDetailes));
    }




    public function update(CoursesDetailesRequest $request,$id)
    {
        // dd($id);
        $courseDetailes = $this->courseDetailesService->updateCourseDetailes($request->validated(),$id);

        if (!$courseDetailes)
        {
            return $this->error('Course Detailes not found or not authorized');
        }

        return $this->success('Course Detailes updated successfully',  new CourseDetailesResource($courseDetailes));

    }



    public function show($id)
    {
        $courseDetailes = $this->courseDetailesService->showCourseDetailes($id);
        // $course = $this->courseDetailesService->showCourseDetailes($courseDetailes);

        if (!$courseDetailes)
        {
            return $this->error('Course Detailes not found or not authorized');
        }
        return $this->success('',  new CourseDetailesResource($courseDetailes));

    }

}
