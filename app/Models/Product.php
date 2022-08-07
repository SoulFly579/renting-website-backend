<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
      "name",
      "total_stock",
        "category_id",
        "active"
    ];

    protected $casts = [
        "active"=>"boolean"
    ];


    protected static function booted()
    {
        static::creating(function ($model) {
            /*TODO unique olup olmadığını araştır*/
            $model->slug = Str::slug($model->name)."-".explode("-",Uuid::uuid1())[0];
            $model->user_id = auth()->user()->id;
        });

        static::updating(function ($model) {
            $model->slug = Str::slug($model->name)."-".explode("-",Uuid::uuid1())[0];
            $model->user_id = auth()->user()->id;
        });
    }

    public function category()
    {
        return $this->hasOne(Category::class,"id","category_id");
    }

    public function rent_times()
    {
        return $this->hasMany(RentTime::class,"product_id","id");
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class,"product_id","id");
    }

    public function variant_groups()
    {
        return $this->hasMany(ProductVariantGroup::class,"product_id","id");
    }
/*
    public function variants()
    {
        return $this->hasManyThrough(ProductVariantValue::class,ProductVariantGroup::class);
    }*/
}
