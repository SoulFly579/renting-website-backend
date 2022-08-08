<?php

namespace App\Http\Controllers\Api;


use App\Http\Requests\ProductAdditionGroup\CreateRequest;
use App\Http\Requests\ProductAdditionGroup\UpdateRequest;
use App\Http\Resources\ProductAdditionGroupResource;
use App\Models\Product;
use App\Models\ProductAdditionGroup;

class ProductAdditionGroupController extends ApiController
{
    public function store(Product $product, CreateRequest $request)
    {
        $product->addition_groups()->create($request->validated());
        return $this->successResponse(null,"Başarılı bir şekilde kayıt edilmiştir.",201);
    }

    public function update(Product $product, ProductAdditionGroup $additionGroup, UpdateRequest $request)
    {
        $additionGroup->update($request->validated());
        return $this->successResponse(null,"Başarılı bir şekilde güncellenmiştir.");
    }

    public function destroy(Product $product, ProductAdditionGroup $additionGroup)
    {
        $additionGroup->options()->delete();
        $additionGroup->delete();
        return $this->successResponse(null,"Başarılı bir şekilde silinmiştir.");
    }
}
