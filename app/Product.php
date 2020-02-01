<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name', 'detail', 'price','stock','discount'
    ];
    protected $table = "products";
}
