<?php

namespace App\Http\Requests\CartItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IncreaseItemRequest extends FormRequest
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
            "variant_id"=>[Rule::requiredIf(fn()=> $this->product->variant_groups->count() > 0 ),Rule::exists("product_variant_values","id")],
            "additions" => [Rule::requiredIf(fn()=> $this->product->addition_groups->count() > 0 ), "array"],
            "additions.*.addition_id" => ["required_with:additions",Rule::exists("product_addition_groups","id")],
            "additions.*.option_id" => ["required_with:additions",Rule::exists("product_addition_options","id")],
        ];
    }
}
