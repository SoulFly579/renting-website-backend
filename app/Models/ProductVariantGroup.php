<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariantGroup extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "name",
        "product_id",
        "product_variant_group_id"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,"product_id","id");
    }

    public function parent()
    {
        return $this->belongsTo(ProductVariantGroup::class,"product_variant_group_id","id");
    }

    public function children()
    {
        return $this->hasMany(ProductVariantGroup::class,"product_variant_group_id","id");
    }

    public function values(){
        return $this->hasMany(ProductVariantValue::class,"product_variant_group_id","id");
    }
}
