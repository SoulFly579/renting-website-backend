<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Products\CreateRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\RentTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends ApiController
{
    public function index()
    {
        $products = ProductResource::collection(Product::orderBy("updated_at","DESC")->with("category")->get());
        return $this->successResponse($products);
    }

    public function create()
    {
        $categories = Category::all();
        return $this->successResponse(ProductCategoryResource::collection($categories));
    }

    public function store(CreateRequest $request)
    {
        $product = Product::create($request->safe()->except("rent_times"));
        foreach ($request->rent_times as $rent_time){
            $product->rent_times()->create($rent_time);
        }
        if($request->hasFile("galleries")){
            foreach ($request->galleries as $gallery){
                $path = Storage::putFile(ProductGallery::PATH_DESTINATION,$gallery,$gallery);
                $product->galleries()->create(["path"=>Str::replace("public","storage",$path)]);
            }
        }
        return $this->successResponse(ProductResource::make($product->load(["galleries","rent_times"])),"Ürün başarılı bir şekilde eklendi.");
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return $this->successResponse(["categories"=>ProductCategoryResource::collection($categories),
            "product"=>ProductResource::make($product->load(["galleries","rent_times","category","variant_groups"]))]);
    }

    public function update(Product $product,UpdateRequest $request){
        $product->update($request->validated());
        $product->load("rent_times");
        return $this->successResponse(ProductResource::make($product),"Ürün başarılı şekilde güncellenmiştir.");
    }

    public function destroy(Product $product)
    {
        /*TODO gallery and whatever has relatinship with product, think what will happen to them */
        $product->delete();
        return $this->successResponse(null,"Ürün başarılı bir şekilde silinmiştir.");
    }
}
