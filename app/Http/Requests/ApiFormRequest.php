<?php

namespace App\Http\Requests;

use App\Traits\ApiFormResponse;
use Illuminate\Foundation\Http\FormRequest;

class ApiFormRequest extends FormRequest
{
    use ApiFormResponse;
}
