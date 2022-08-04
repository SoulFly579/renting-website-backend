<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RentTimes\CreateRequest;
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
        $rent_time = RentTime::create($request->validated());
        $rent_time->load("product");
        return $this->successResponse($rent_time);
    }
}
