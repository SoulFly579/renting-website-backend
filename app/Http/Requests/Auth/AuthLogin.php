<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;

class AuthLogin extends ApiFormRequest
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
            "email"=>"required|email",
            "password"=>"required|max:255",
            "remember_me"=>"boolean"
        ];
    }
}
