<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantGallery extends Model
{
    use HasFactory;

    const PATH_DESTINATION = "public/products/variants/galleries";

    protected $fillable = [
      "variant_id",
      "path"
    ];



}
