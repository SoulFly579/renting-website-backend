<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RentTimes\CreateRequest;
use App\Http\Requests\RentTimes\UpdateRequest;
use App\Models\Product;
use App\Models\RentTime;

class RentTimeController extends ApiController
{
    public function index()
    {
        $rent_times = RentTime::with("product")->get();
        return $this->successResponse($rent_times);
    }

    public function create()
    {
        $products = Product::all();
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
        $products = Product::all();
        return $this->successResponse(["rent_time"=>$rentTime,"products"=>$products]);
    }

    public function update(RentTime $rentTime, UpdateRequest $request)
    {
        $rentTime->update($request->validated());
        $rentTime->load("product");
        return $this->successResponse($rentTime,"Başarılı bir şekilde güncellenmiştir.");
    }

    public function destroy(RentTime $rentTime)
    {
        $rentTime->delete();
        return $this->successResponse(null,"Kiralama süre seçeneği başarılı bir şekilde silinmiştir.");
    }

}
