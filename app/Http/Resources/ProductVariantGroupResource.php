<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantGroupResource extends JsonResource
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
            "name"=>$this->name,
            "product"=>ProductResource::make($this->whenLoaded("product")),
            "parent"=>ProductVariantGroupResource::make($this->whenLoaded("parent")),
            "child"=>ProductVariantGroupResource::make($this->whenLoaded("child")),
            "values"=>ProductVariantValueResource::collection($this->whenLoaded("values")),
        ];
        //return parent::toArray($request);
    }
}
