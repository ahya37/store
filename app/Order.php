<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'users_id','date','name','phone_number','address','payment_metode','description_order'
    ];

    protected $hidden = [];

    public function users()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }
}
