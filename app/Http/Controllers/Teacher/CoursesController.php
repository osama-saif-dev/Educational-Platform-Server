<?php

namespace App\Http\Controllers\Teacher;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Discount;
use App\Trait\HandleToken;
use Illuminate\Http\Request;
use App\Trait\HandleResponse;
use App\Http\Controllers\Controller;
use App\Interfaces\Teacher\CourseInterface;
use App\Http\Requests\Teacher\CoursesRequest;
use App\Http\Resources\Teacher\CourseResource;

class CoursesController extends Controller
{
    use HandleResponse, HandleToken;

    public function __construct(private CourseInterface $courseService)
    {


    }


    public function index(Request $request)
    {
        $search = $request->query('search'); // أو $request->search

        $courses = $this->courseService->getCourses($search);

        return $this->success(
            'Courses retrieved successfully',
            CourseResource::collection($courses)
        );
    }




    public function get_copones()
    {
        try
        {
            $discounts = Discount::where('end_date', '>=', Carbon::today())->get();
            return $this->data(compact('discounts'), '', 200);

        } catch (\Throwable $th)
        {
            return $this->errorsalertMessage($th, 'You cannot perform this request right now. Please try again later.');
        }
    }




    public function store(CoursesRequest $request)
    {
        $course = $this->courseService->createCourse($request->validated());
        if(!$course)
        {
            return $this->error('exactly one category with this name is allowed');
        }
        return $this->success('Course created successfully', new CourseResource($course));
    }




    public function update(CoursesRequest $request,Course $course)
    {
        $course = $this->courseService->updateCourse($request->validated(),$course);

        if (!$course)
        {
            return $this->error('Course not found or not authorized');
        }

        return $this->success('Course updated successfully',  new CourseResource($course));

    }



    public function show(Course $course)
    {
        $course = $this->courseService->showCourse($course);

        if (!$course)
        {
            return $this->error('Course not found or not authorized');
        }

        return $this->success('',  new CourseResource($course));

    }


}
