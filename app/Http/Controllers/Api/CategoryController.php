<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Categories\CreateRequest;
use App\Http\Requests\Categories\UpdateRequest;
use App\Http\Resources\ProductCategoryResource;
use App\Jobs\InformationMailMakingDeactiveProductJob;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends ApiController
{
    public function index()
    {
        $categories = Category::withCount("products")->get();
        return $this->successResponse(ProductCategoryResource::collection($categories));
    }

    public function store(CreateRequest $request)
    {
        $category = Category::create($request->validated());
        return $this->successResponse(ProductCategoryResource::make($category),"Kategori başarıyla kayıt edildi.",201);
    }

    public function update(Category $category, UpdateRequest $request)
    {
        $category->update($request->validated());
        return $this->successResponse(ProductCategoryResource::make($category),"Başarılı bir şekilde güncellendi.");
    }

    public function destroy(Category $category)
    {
        $ids = $category->products()->where("active",true)->get(["user_id","id"]);
        InformationMailMakingDeactiveProductJob::dispatch($ids);
        $category->products()->update(["active"=>false]);
        $category->delete();
        return $this->successResponse(null,"Kategori başarılı bir şekilde silinmiştir.");
    }

}
