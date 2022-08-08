<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariantValue extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "product_variant_group_id",
        "name",
        "stock"
    ];

    public function galleries()
    {
        return $this->hasMany(ProductVariantGallery::class,"variant_id","id");
    }
}
