<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductVariantGroup\CreateRequest;
use App\Http\Requests\ProductVariantGroup\UpdateRequest;
use App\Http\Resources\ProductVariantGroupResource;
use App\Models\Product;
use App\Models\ProductVariantGroup;

class ProductVariantGroupController extends ApiController
{
    public function index()
    {
        $product_variants_groups = ProductVariantGroupResource::collection(ProductVariantGroup::all());
        return $this->successResponse($product_variants_groups);
    }

    public function store(Product $product,CreateRequest $request)
    {
        foreach ($request->variants as $variant){
            $product->variant_groups()->create($variant);
        }

        return $this->successResponse(null,"Varyantlar, ".$product->name." adlı ürüne başarılı bir şekilde eklenmiştir.",201);
    }

    public function edit(Product $product, ProductVariantGroup $variant_group)
    {
        return $this->successResponse(ProductVariantGroupResource::make($variant_group));
    }

    public function update(Product $product, ProductVariantGroup $variant_group, UpdateRequest $request)
    {
        $variant_group->update($request->validated());
        return $this->successResponse(null,"Varyant başarılı bir şekilde güncellenmiştir.");
    }

    public function destroy(Product $product, ProductVariantGroup $variant_group)
    {
        $variant_group->children()->each(function ($child){
            $child->values()->delete();
        });
        $variant_group->children()->delete();
        $variant_group->values()->delete();
        $variant_group->delete();
        return $this->successResponse(null,"Başarılı bir şekilde silinmiştir.");
    }
}
