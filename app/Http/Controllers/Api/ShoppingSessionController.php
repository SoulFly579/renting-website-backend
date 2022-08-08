<?php

namespace App\Http\Controllers\Api;


class ShoppingSessionController extends ApiController
{
    public function index()
    {
        return $this->successResponse(auth()->user()->cart);
    }
}
