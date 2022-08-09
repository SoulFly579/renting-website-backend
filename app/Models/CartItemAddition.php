<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItemAddition extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
      "cart_item_id",
      "option_id",
        "addition_id"
    ];

    public function addition_group()
    {
        return $this->hasOne(ProductAdditionGroup::class,"id","addition_id");
    }

    public function addition_option()
    {
        return $this->hasOne(ProductAdditionOption::class,"id","option_id");
    }

}
