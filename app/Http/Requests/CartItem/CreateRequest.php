<?php

namespace App\Http\Requests\CartItem;

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
        return auth()->hasUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "quantity" => ["required","min:1"],
            "variant_id"=>["nullable",Rule::exists("product_variant_values","id")]
        ];
    }
}
