<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
      "session_id",
        "product_id",
        "variant_id",
        "quantity"
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->session_id = auth()->user()->shopping_session->id;
        });
    }

    public function session()
    {
        return $this->belongsTo(ShoppingSession::class,"session_id","id");
    }

/*    public function product()
    {
        return $this->belongsTo(Product::class,"product_id","id");
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariantValue::class,"variant_id","id")->with("group");
    }*/
}
