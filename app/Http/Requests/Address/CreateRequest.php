<?php

namespace App\Http\Requests\Address;

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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name"=>["required","string","max:255", Rule::unique('addresses')->whereNull('deleted_at')],
            "city"=>["required","string","max:255"],
            "address"=>["required","string"],
            "receiver_full_name"=>["required","string","max:255"],
        ];
    }
}
