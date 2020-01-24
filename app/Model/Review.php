<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    //
    protected $dates = ['deleted_at'];
    protected $table = "reviews";
    protected $fillable = [
        'customer', 'review', 'star', 'product_id'
    ];
}
