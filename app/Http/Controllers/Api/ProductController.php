<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Products\CreateRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\RentTime;

class ProductController extends ApiController
{
    public function index()
    {
        $products = Product::orderBy("updated_at","DESC")->with("category")->get();
        return $this->successResponse($products);
    }

    public function create()
    {
        $categories = Category::all();
        return $this->successResponse($categories);
    }

    public function store(CreateRequest $request)
    {
        $product = Product::create($request->safe()->except("rent_times"));
        foreach ($request->rent_times as $rent_time){
            $product->rent_times()->create($rent_time);
        }
        $product->load("rent_times");
        return $this->successResponse($product,"Ürün başarılı bir şekilde eklendi.");
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return $this->successResponse(["categories"=>$categories,"product"=>$product]);
    }

    public function update(Product $product,UpdateRequest $request){
        $product->update($request->validated());
        return $this->successResponse($product,"Ürün başarılı şekilde güncellenmiştir.");
    }

    public function destroy(Product $product)
    {
        /*TODO gallery and whatever has relatinship with product, think what will happen to them */
        $product->delete();
        return $this->successResponse(null,"Ürün başarılı bir şekilde silinmiştir.");
    }
}
