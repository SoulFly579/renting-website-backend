<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGallery extends Model
{
    use HasFactory;

    const PATH_DESTINATION = "public/products/galleries";

    protected $fillable = [
        "path",
        "product_id"
    ];

    public function product()
    {
        return $this->hasOne(Product::class,"id","product_id");
    }
}
