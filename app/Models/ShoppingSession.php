<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "total"
    ];

    public function user(){
        return $this->hasOne(User::class,"id","user_id");
    }

    public function cart()
    {
        return $this->hasMany(CartItem::class,"session_id","id");
    }
}
