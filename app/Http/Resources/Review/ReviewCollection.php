<?php

namespace App\Http\Resources\Review;

use Illuminate\Http\Resources\Json\Resource;

class ReviewCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'customer' => $this->customer,
            'body' => $this->review,
            'star' =>   $this->star
        ];
    }
}
