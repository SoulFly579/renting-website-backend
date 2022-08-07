<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RentTimes\CreateRequest;
use App\Http\Requests\RentTimes\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RentTimeResource;
use App\Models\Product;
use App\Models\RentTime;

class RentTimeController extends ApiController
{
    public function index()
    {
        return $this->successResponse(RentTimeResource::collection(RentTime::with("product")->get()));
    }

    public function create()
    {
        $products = ProductResource::collection(Product::all());
        return $this->successResponse($products);
    }

    public function store(CreateRequest $request)
    {
        $request->collect('rent_times')->each(function ($rent_time) {
            $product = Product::where("id",$rent_time["product_id"])->first();
            if($product){
                $new_rent_time = RentTime::create($rent_time);
            }
        });
        return $this->successResponse(null,"Başarılı bir şekilde eklenmiştir.",201);
    }

    public function edit(RentTime $rentTime)
    {
        return $this->successResponse(["rent_time"=>RentTimeResource::make($rentTime->load("product")),"products"=>ProductResource::collection(Product::all())]);
    }

    public function update(RentTime $rentTime, UpdateRequest $request)
    {
        $rentTime->update($request->validated());
        return $this->successResponse(RentTimeResource::make($rentTime->load("product")),"Başarılı bir şekilde güncellenmiştir.");
    }

    public function destroy(RentTime $rentTime)
    {
        $rentTime->delete();
        return $this->successResponse(null,"Kiralama süre seçeneği başarılı bir şekilde silinmiştir.");
    }

}
