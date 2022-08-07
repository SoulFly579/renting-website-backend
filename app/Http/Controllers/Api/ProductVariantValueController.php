<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductVariantValues\CreateRequest;
use App\Http\Requests\ProductVariantValues\UpdateRequest;
use App\Http\Resources\ProductVariantGroupResource;
use App\Http\Resources\ProductVariantValueResource;
use App\Models\Product;
use App\Models\ProductVariantGroup;
use App\Models\ProductVariantValue;

class ProductVariantValueController extends ApiController
{
    public function create(){
        $variants = ProductVariantGroupResource::collection(ProductVariantGroup::all());
        return $this->successResponse($variants);
    }

    public function store(Product $product, ProductVariantGroup $variantGroup, CreateRequest $request)
    {
        foreach ($request->variants as $variant){
            $variantGroup->values()->create($variant);
        }
        return $this->successResponse(null,"Varyantlar başarılı bir şekilde kayıt edilmiştir.",201);
    }

    public function edit(Product $product, ProductVariantGroup $variantGroup, ProductVariantValue $variantValue)
    {
        return $this->successResponse(["variant_groups"=>ProductVariantGroupResource::collection(ProductVariantGroup::all()),
            "variant_value"=>ProductVariantValueResource::make($variantValue)]);
    }

    public function update(Product $product, ProductVariantGroup $variantGroup, ProductVariantValue $variantValue, UpdateRequest $request)
    {
        $variantValue->update($request->validated());
        return $this->successResponse(null,$variantValue->name." adlı varyant başarılı bir şekilde güncellenmiştir.");
    }

    public function destroy(Product $product, ProductVariantGroup $variantGroup, ProductVariantValue $variantValue)
    {
        $variantValue->delete();
        return $this->successResponse(null,"Başarılı bir şekilde varyant silinmiştir.");
    }
}
