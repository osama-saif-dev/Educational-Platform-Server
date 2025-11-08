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
        if ($this->teacher->count() == 0) {
            return false;
        }
        $data['admin_id'] = $this->teacher->id;

        $category = Category::create($data);
        return $category;
    }


    public function getCategories($search = null)
    {
        $allowedSorts = ['created_at', 'updated_at'];

        // خذ القيم من query string لو موجودة
        $sortBy = in_array(request('sortBy'), $allowedSorts) ? request('sortBy') : 'created_at';
        $sortDir = request('sortDir') == 'asc' ? 'asc' : 'desc';

        $categories = Category::where('admin_id', $this->teacher->id)
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate(5); // بدون appends

        return $categories;
    }


    // public function getCategories($search = null)
    // {

    //     $allowedSorts = ['created_at', 'updated_at'];


    //     $sortBy = in_array(request('sort_by'), $allowedSorts) ? request('sort_by') : 'created_at';
    //     $sortDir = request('sort_dir') == 'asc' ? 'asc' : 'desc';


    //     $categories = Category::where('admin_id', $this->teacher->id)->where(function ($query) use($search)
    //     {
    //         $query->where('name', 'like', '%' . $search . '%');
    //     }) ->orderBy($sortBy, $sortDir)->paginate(5);


    //     return $categories;
    // }



    public function updateCategory(array $data, Category $category)
    {
        // dd($category);
        $data['admin_id'] = $this->teacher->id;
        $category = Category::where('id', $category->id)->where('admin_id', $this->teacher->id)->first();
        if (!$category) {
            return false;
        }
        $category->update($data);
        return $category;
    }


    public function showCategory(Category $category)
    {
        // dd($category);

        $category = Category::where('id', $category->id)->where('admin_id', $this->teacher->id)->with('teacher')->first();
        if (!$category) {
            return false;
        }
        return $category;
    }

    public function deleteCategory($id) {}
}
