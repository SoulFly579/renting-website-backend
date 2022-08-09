<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          "id"=>$this->id,
          "product"=>ProductResource::make($this->product->load(["category","galleries"])),
            "variant"=> ProductVariantValueResource::make($this->variant->load("group")),
            "quantity"=>$this->quantity,
            "rent_time" => RentTimeResource::make($this->rent_time),
            "addition" => ProductAdditionOptionResource::collection($this->whenLoaded("additions",function (){
                return ProductAdditionOptionResource::collection($this->additions->load("addition_group","addition_option"));
            })),
        ];
        //return parent::toArray($request);
    }
}
