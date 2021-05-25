<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    
    protected $fillable = [
        'name','users_id','top_categories_id','categories_id','price','stock','weight','profit_sharing','point','description','slug'
    ];

    protected $hidden = [];

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class,'products_id','id');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','users_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'categories_id','id');
    }

     public function topCategory()
    {
        return $this->belongsTo(TopCategory::class,'top_categories_id','id');
    }
}
