<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductVariantGallery\CreateRequest;
use App\Models\Product;
use App\Models\ProductVariantGallery;
use App\Models\ProductVariantGroup;
use App\Models\ProductVariantValue;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductVariantGalleryController extends ApiController
{
    public function store(Product $product, ProductVariantGroup $variantGroup, ProductVariantValue $variantValue, CreateRequest $request)
    {
        foreach ($request->images as $image){
            $path = Storage::putFile(ProductVariantGallery::PATH_DESTINATION,$image);
            $variantValue->galleries()->create(["path" => Str::replace("public","storage",$path)]);
        }

        return $this->successResponse(null,"Başarılı bir şekilde yüklenmiştir.",201);
    }

    public function destroy(Product $product, ProductVariantGroup $variantGroup, ProductVariantValue $variantValue, ProductVariantGallery $gallery)
    {
        $path = Str::replace("storage","public",$gallery->path);
        if(Storage::exists($path)){
            Storage::delete($path);
        }
        $gallery->forceDelete();
        return $this->successResponse(null,"Varyant görseli başarılı bir şekilde silinmiştir.");
    }
}
