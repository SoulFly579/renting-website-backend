<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ProductGallery\CreateRequest;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductGalleryController extends ApiController
{
    public function store(Product $product,CreateRequest $request){
        foreach ($request->images as $image){
            $path = Storage::putFile(ProductGallery::PATH_DESTINATION,$image);
            ProductGallery::create(["path" => Str::replace("public","storage",$path),"product_id"=>$product->id]);
        }
        return $this->successResponse(null,"Fotoğraflar başarılı bir şekilde güncellendi.",201);
    }

    public function destroy(Product $product, ProductGallery $gallery)
    {
        $path = Str::replace("storage","public",$gallery->path);
        if(Storage::exists($path)){
            Storage::delete($path);
        }
        $gallery->forceDelete();
        return $this->successResponse(null,"Görsel başarılı bir şekilde silinmiştir.");
    }
}
