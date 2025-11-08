<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Trait\HandleToken;
use Illuminate\Http\Request;
use App\Trait\HandleResponse;
use App\Http\Middleware\IsTeacher;
use App\Http\Requests\Admin\CategoryRequest;
use App\Interfaces\Teacher\CategoryInterface;
use App\Http\Resources\Teacher\CategoryResouce;

class CategoriesController extends Controller
{

    use HandleResponse, HandleToken;

    public function __construct(private CategoryInterface $categoryService)
    {


    }

    public function index(Request $request)
    {
        $search = $request->query('search'); // أو $request->search

        $categories = $this->categoryService->getCategories($search);

        return $this->success(
            'Categories retrieved successfully',
            CategoryResouce::collection($categories)
        );
    }







    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request->validated());
        if(!$category)
        {
            return $this->error('exactly one category with this name is allowed');
        }
        return $this->success('Category created successfully', new CategoryResouce($category));
    }




    public function update(CategoryRequest $request,Category $category)
    {
        $category = $this->categoryService->updateCategory($request->validated(),$category);

        if (!$category)
        {
            return $this->error('Category not found or not authorized');
        }

        return $this->success('Category updated successfully',  new CategoryResouce($category));

    }



    public function show(Category $category)
    {
        $category = $this->categoryService->showCategory($category);

        if (!$category)
        {
            return $this->error('Category not found or not authorized');
        }

        return $this->success('',  new CategoryResouce($category));

    }


}
