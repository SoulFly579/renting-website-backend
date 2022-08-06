<?php

namespace App\Http\Requests\ProductGallery;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasAnyRole("admin","renter");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "images"=>["required","array"],
            "images.*"=>["required","file","mimes:jpg,jpeg,png"],
        ];
    }
}
