<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'products_id','price'
    ];

    protected $hidden = [];

    public function product()
    {
        return $this->belongsTo(Product::class,'products_id','id');
    }

}
