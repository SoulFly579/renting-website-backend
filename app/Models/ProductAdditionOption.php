<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAdditionOption extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
      "addition_group_id",
      "name",
      "price"
    ];

    public function group() : BelongsTo
    {
        return $this->belongsTo(ProductAdditionGroup::class,"addition_group_id","id");
    }
}
