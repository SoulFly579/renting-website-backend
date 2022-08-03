<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "user_id",
        "city",
        "name",
        "receiver_full_name",
        "address",
    ];

    public function scopeAuth($query)
    {
        $query->where("user_id",auth()->user()->id);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->user_id = auth()->user()->id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class,"id","user_id");
    }

}
