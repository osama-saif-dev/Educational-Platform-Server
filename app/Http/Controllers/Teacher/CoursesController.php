<?php

namespace App\Http\Controllers\Teacher;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Discount;
use App\Trait\HandleToken;
use Illuminate\Http\Request;
use App\Trait\HandleResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\CoursesRequest;

class CoursesController extends Controller
{
    use HandleResponse, HandleToken;


    public function index()
    {
        $courses = Course::all();
        return $this->data(compact('courses'), '', 200);

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
        // return 'dd';
        try
        {
            $create = Course::create(
            [
                'copon_id'              => $request->copon_id,
                'teacher_id'            => auth()->user()->id,
                'title'                 => $request->title,
                'price'                 => $request->price,
                'desc'                  => $request->desc,
                'video'                 => $request->video,
            ]);

            return $this->successMessage('Course Created Successfully');

        } catch (\Throwable $th)
        {
            return $this->errorsalertMessage($th, 'You cannot perform this request right now. Please try again later.');
        }
    }


    public function update(CoursesRequest $request,$id)
    {
        // return 'dd';
        try
        {
            $course = Course::find($id);
            if ($course)
            {
                $course->update(
                [
                    'copon_id'              => $request->copon_id,
                    'teacher_id'            => auth()->user()->id,
                    'title'                 => $request->title,
                    'price'                 => $request->price,
                    'desc'                  => $request->desc,
                    'video'                 => $request->video,
                ]);
                return $this->successMessage('Course Updated Successfully');

                }else
            {
                return $this->errorsMessage([
                    'error' => 'This Course Not Found',
                    'status' => false
                ]);
            }

        } catch (\Throwable $th)
        {
            return $this->errorsalertMessage($th, 'You cannot perform this request right now. Please try again later.');
        }
    }


}
