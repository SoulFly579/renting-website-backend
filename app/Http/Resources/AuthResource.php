<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
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
            "full_name"=>$this->full_name,
            "email"=>$this->email,
            "tckn"=>$this->tckn,
            "phone_number"=>$this->phone_number,
            "credit"=>$this->credit,
            "email_verified_at"=>$this->email_verified_at,
            "roles"=>$this->roles,
            "products"=>ProductResource::collection($this->whenLoaded("products")),
            "cart"=>CartResource::make($this->whenLoaded("cart")),
            //"cart"=>$this->whenLoaded(""),
        ];
        /*return parent::toArray($request);*/
    }
}
