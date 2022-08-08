<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantValueResource extends JsonResource
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
            "parent_id"=>ProductVariantGroupResource::make($this->whenLoaded("parent")),
            "name" => $this->name,
            "stock"=>$this->stock,
            "galleries"=> ProductVariantValueGalleryResource::collection($this->whenLoaded("galleries")),
        ];
        //return parent::toArray($request);
    }
}
