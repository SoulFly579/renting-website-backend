<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductAdditionOptionResource extends JsonResource
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
           "group" => ProductAdditionGroupResource::make($this->whenLoaded("addition_group")),
           "name" => $this->addition_option->name,
             "price"=>$this->addition_option->price
         ];
        //   return parent::toArray($request);
    }
}
