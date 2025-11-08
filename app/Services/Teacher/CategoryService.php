<?php

namespace App\Services\Teacher;

use App\Interfaces\Teacher\CategoryInterface;
use App\Models\Category;

class CategoryService implements CategoryInterface
{
    private $teacher;


    public function __construct()
    {
        $this->teacher = auth()->user();
    }

    public function createCategory(array $data)
    {
        if($this->teacher->count() == 0)
        {
            return false;
        }
        $data['admin_id'] = $this->teacher->id;

        $category = Category::create($data);
        return $category;
    }



    public function getCategories($search = null)
    {
        $categories = Category::where('admin_id', $this->teacher->id)->where(function ($query) use($search)
        {
            $query->where('name', 'like', '%' . $search . '%');
        })->latest()->paginate(5);


        return $categories;
    }



    public function updateCategory(array $data,Category $category)
    {
        // dd($category);
        $data['admin_id'] = $this->teacher->id;
        $category = Category::where('id', $category->id)->where('admin_id', $this->teacher->id)->first();
        if(!$category)
        {
            return false;
        }
        $category->update($data);
        return $category;
    }


    public function showCategory(Category $category)
    {
        // dd($category);

        $category = Category::where('id', $category->id)->where('admin_id', $this->teacher->id)->with('teacher')->first();
        if(!$category)
        {
            return false;
        }
        return $category;
    }

    public function deleteCategory($id)
    {

    }
}

