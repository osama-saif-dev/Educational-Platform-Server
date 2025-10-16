<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Trait\HandleToken;
use Illuminate\Http\Request;
use App\Trait\HandleResponse;
use App\Http\Requests\Admin\CategoryRequest;

class CategoriesController extends Controller
{

    use HandleResponse, HandleToken;

    public function index()
    {
        $categories = Category::all();
        return $this->data(compact('categories'), '', 200);
    }

    public function store(CategoryRequest $request)
    {
        try
        {
            $create = Category::create(
            [
                'name'      => $request->name,
                'admin_id'  => auth()->user()->id,
            ]);

            return $this->successMessage('Category Created Successfully');

        } catch (\Throwable $th)
        {
           return $this->errorsMessage(
            [
                    'error' => 'This Category Not Created',
                    'status' => false
            ]);
        }
    }


    public function update(CategoryRequest $request,$id)
    {
        try
        {
            $category = Category::find($id);

            if ($category)
            {
                $category->update(
                [
                    'name'              => $request->name,
                    'admin_id'          => auth()->user()->id,
                ]);
                return $this->successMessage('Category  Updated Successfully');

                }else
            {
                return $this->errorsMessage([
                    'error' => 'This Category Not Found',
                    'status' => false
                ]);
            }

        } catch (\Throwable $th)
        {
            return $this->errorsalertMessage($th, 'You cannot perform this request right now. Please try again later.');
        }
    }
}
