<?php

namespace App\Http\Resources;

use App\Models\ProductVariantValue;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
          "total_stock"=>$this->total_stock,
          "slug"=>$this->slug,
          "active"=>$this->active,
          "category"=>ProductCategoryResource::make($this->whenLoaded("category")),
          "rent_times"=>RentTimeResource::collection($this->whenLoaded("rent_times")),
          "galleries"=>ProductGalleryResource::collection($this->whenLoaded("galleries")),
          "variants" => ProductVariantGroupResource::collection($this->whenLoaded("variant_groups",function (){
              return ProductVariantValueResource::collection($this->variant_groups->load("values"));
          })),
          "additions" => ProductAdditionGroupResource::collection($this->whenLoaded("addition_groups"))

            /*TODO additionlar ve varyantlar eklenecek*/
        ];
        //return parent::toArray($request);
    }
}
