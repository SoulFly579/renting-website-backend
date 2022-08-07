<?php

namespace App\Http\Requests\ProductVariantGroup;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasAnyRole(["admin","renter"]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => ["required","string",Rule::unique("product_variant_groups")->whereNull("deleted_at")->ignore($this->variant_group->name,"name")],
            "product_variant_group_id" => ["nullable", Rule::exists("product_variant_groups")->whereNull("deleted_at")->where("id")],
        ];
    }
}
