<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
      "session_id",
        "product_id",
        "variant_id",
        "quantity",
        "rent_time_id",
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->session_id = auth()->user()->shopping_session->id;
        });
    }

    /**
     * @param $query
     * @return mixed
     */

    public function scopeAuth($query)
    {
        return $query->where("session_id", auth()->user()->shopping_session->id);
    }

    /**
     * @param $query
     * @return mixed
     */

    public function scopeSame($query,$request)
    {
        return $query->where("product_id", $request->product_id)->where("variant_id",$request->variant_id)->where("rent_time_id",$request->rent_time_id);
    }

    public function session() : BelongsTo
    {
        return $this->belongsTo(ShoppingSession::class,"session_id","id");
    }

    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class,"product_id","id");
    }

    public function variant() : BelongsTo
    {
        return $this->belongsTo(ProductVariantValue::class,"variant_id","id");
    }

    public function rent_time() : HasOne
    {
        return $this->hasOne(RentTime::class,"id","rent_time_id");
    }

    public function additions() : HasMany
    {
        return $this->hasMany(CartItemAddition::class,"cart_item_id","id");
    }
}
