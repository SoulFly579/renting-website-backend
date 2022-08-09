<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CartItem\CreateRequest;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductAdditionOption;
use App\Models\ProductVariantValue;
use App\Models\RentTime;

class CartItemController extends ApiController
{
    public function add(Product $product,CreateRequest $request)
    {
        if(!auth()->user()->shopping_session){
            auth()->user()->shopping_session()->create();
        }
        if(!$product->variant_values()->find($request->variant_id)){
            return $this->errorResponse("Invalid request",400);
        }

        // Check if product is in the cart, increase the count
        $total = auth()->user()->shopping_session->total;
        $cartItem = CartItem::auth()->same($request->merge(["product_id"=>$product->id]))->first();
        $rentingCost = RentTime::select("cost")->where("id",$request->rent_time_id)->firstOrFail()->cost;
        if($cartItem){
            $cartItem->update(["quantity"=> ($cartItem->quantity + $request->quantity)]);
            $total = $total + ($cartItem->quantity * $rentingCost);
        }else{
            $cartItem = CartItem::create(array_merge(["product_id"=>$product->id],$request->validated()));
            $total = $rentingCost;
        }

        ProductVariantValue::where("id",$request->variant_id)->decrement("stock",1);

        if($request->additions){
            foreach ($request->additions as $addition){
                $additionPrice = ProductAdditionOption::select("price")->where("id",$addition["option_id"])->firstOrFail()->price;
                $cartItem->additions()->create($addition);
                $total = $total + $additionPrice;
            }
        }

        auth()->user()->shopping_session()->update(["total"=>$total]);
        $product->decrement("total_stock",1);

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
