<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentTime extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "name",
        "product_id",
        "amount_of_time",
        "type_of_period",
        "cost"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,"product_id","id");
    }

}
