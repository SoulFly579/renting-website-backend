<?php

namespace App\Http\Controllers\Api;


use App\Http\Resources\CartResource;

class ShoppingSessionController extends ApiController
{
    public function index()
    {
        return $this->successResponse(CartResource::make(auth()->user()->cart));
    }
}
