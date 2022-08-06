<?php

namespace App\Http\Requests\Categories;

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
        return auth()->user()->hasRole("admin");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name"=>["string","required","max:255",Rule::unique("categories")->whereNull("deleted_at")]
        ];
    }
}
