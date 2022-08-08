<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductAdditionOption\CreateRequest;
use App\Http\Requests\ProductAdditionOption\UpdateRequest;
use App\Models\Product;
use App\Models\ProductAdditionGroup;
use App\Models\ProductAdditionOption;

class ProductAdditionOptionController extends ApiController
{
    public function store(Product $product, ProductAdditionGroup $additionGroup, CreateRequest $request)
    {
        $additionGroup->options()->create($request->validated());
        return $this->successResponse(null,"Başarıyla eklenmiştir.",201);
    }

    public function update(Product $product, ProductAdditionGroup $additionGroup, ProductAdditionOption $additionOption, UpdateRequest $request)
    {
        $additionOption->update($request->validated());
        return $this->successResponse(null,"Başarıyla güncellenmiştir.");
    }

    public function destroy(Product $product, ProductAdditionGroup $additionGroup, ProductAdditionOption $additionOption)
    {
        $additionOption->delete();
        return $this->successResponse(null,"Başarıyla silinmiştir.");
    }
}
