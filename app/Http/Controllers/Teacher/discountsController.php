<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Discount;
use App\Trait\HandleToken;
use Illuminate\Http\Request;
use App\Trait\HandleResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\DiscountsRequest;

class discountsController extends Controller
{
    use HandleResponse, HandleToken;
    public function index()
    {

        try
        {
            $discounts = Discount::all();
            return $this->data(compact('discounts'), '', 200);

        } catch (\Throwable $th)
        {
            return $this->errorsalertMessage($th, 'You cannot perform this request right now. Please try again later.');
        }
    }

    public function store(DiscountsRequest $request)
    {
        try
        {
            $create = Discount::create(
            [
                'name'              => $request->name,
                'teacher_id'        => auth()->user()->id,
                'start_date'        => $request->start_date,
                'end_date'          => $request->end_date,
                'amount'            => $request->amount,
            ]);

            return $this->successMessage('Discount Created Successfully');

        } catch (\Throwable $th) {
            return $this->errorsalertMessage($th, 'You cannot perform this request right now. Please try again later.');
        }
    }



    public function update(DiscountsRequest $request,$id)
    {
        try
        {
            $discount = Discount::find($id);
            if ($discount)
            {
                $discount->update(
                [
                    'name'              => $request->name,
                    'teacher_id'        => auth()->user()->id,
                    'start_date'        => $request->start_date,
                    'end_date'          => $request->end_date,
                    'amount'            => $request->amount,
                ]);
                return $this->successMessage('Discount Updated Successfully');
            }else
            {
                return $this->errorsMessage([
                    'error' => 'This Discount Not Found',
                    'status' => false
                ]);
            }




        } catch (\Throwable $th) {
            return $this->errorsalertMessage($th, 'You cannot perform this request right now. Please try again later.');
        }
    }
}
