<?php

namespace App\Interfaces\Teacher;

use App\Models\Category;

interface CategoryInterface
{
    public function createCategory(array $data);
    public function getCategories();
    public function updateCategory(array $data,Category $category);
    public function showCategory(Category $category);
    public function deleteCategory($id);
}
