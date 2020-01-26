<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    protected $dates = ['deleted_at'];
    protected $table = "products";
    protected $fillable = [
      'name', 'detail', 'price', 'stock', 'discount'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
