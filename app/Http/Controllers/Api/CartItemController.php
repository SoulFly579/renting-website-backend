<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CartItem\CreateRequest;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\Product;

class CartItemController extends ApiController
{
    public function add(Product $product,CreateRequest $request)
    {
        if(!$product->variant_values()->find($request->variant_id)){
            return $this->errorResponse("Invalid request",400);
        }
        // TODO check if user cart has this item, if it is then increase the quantity of the item.
        CartItem::create(array_merge(["product_id"=>$product->id],$request->validated()));
        return $this->successResponse(CartResource::make(auth()->user()->cart),"Başarılı bir şekilde ürün sepete eklendi.",201);
    }

    public function increase()
    {

    }

    public function decrease()
    {

    }

    public function clear(){

    }
}
