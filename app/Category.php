<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name','photo','slug','top_categories_id'
    ];

    protected $hidden = [];

    public function topCategory()
    {
        return $this->belongsTo(TopCategory::class,'top_categories_id','id');
    }
}
