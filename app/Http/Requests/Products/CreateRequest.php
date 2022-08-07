<?php

namespace App\Http\Requests\Products;

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
        return auth()->user()->hasAnyRole("renter","admin");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name"=>["string","max:255","required"],
            "category_id"=>["required",Rule::exists("categories")->whereNull("deleted_at")->where("id")],
            "total_stock"=>["numeric","required","min:1"],
            "rent_times" => ["nullable","array"],
            "rent_times.*.name"=>["string","required_with:rent_times","max:255",Rule::unique("rent_times")->whereNull("deleted_at")],
            "rent_times.*.amount_of_time"=>["numeric","required_with:rent_times"],
            "rent_times.*.type_of_period"=>["string","required_with:rent_times","max:255"],
            "galleries"=> ["array","nullable"],
            "galleries.*" => ["required_with:galleries","file","mimes:jpg,png,jpeg"],
        ];
    }
}
