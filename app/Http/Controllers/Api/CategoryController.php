<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Categories\CreateRequest;
use App\Http\Requests\Categories\UpdateRequest;
use App\Models\Category;

class CategoryController extends ApiController
{
    public function index()
    {
        $categories = Category::withCount("products")->get();
        return $this->successResponse($categories);
    }

    public function store(CreateRequest $request)
    {
        $category = Category::create($request->validated());
        return $this->successResponse($category,"Kategori başarıyla kayıt edildi.",201);
    }

    public function update(Category $category, UpdateRequest $request)
    {
        $category->update($request->validated());
        return $this->successResponse($category,"Başarılı bir şekilde güncellendi.");
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return $this->successResponse(null,"Kategori başarılı bir şekilde silinmiştir.");
    }

}
