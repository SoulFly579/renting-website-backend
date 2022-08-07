<?php

namespace App\Http\Requests\ProductVariantValues;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasAnyRole(["renter","admin"]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "variants"=>["array","required"],
            "variants.*.name"=>["required","string",Rule::unique("product_variant_values")->whereNull("deleted_at")],
            "variants.*.stock"=>["required","numeric","min:1"],
        ];
    }
}
