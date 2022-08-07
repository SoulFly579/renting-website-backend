<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RentTimeResource extends JsonResource
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
          "amount_of_time"=>$this->amount_of_time,
          "type_of_period"=>$this->type_of_period,
          "product"=> ProductResource::make($this->whenLoaded("product"))
        ];
        //return parent::toArray($request);
    }
}
