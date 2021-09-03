<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BestSeller extends Model
{
   protected $fillable = [
        'product_id'
    ];

    protected $hidden = [];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
