<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'date','name','phone_number','address','payment_metode','description_order'
    ];

    protected $hidden = [];
}
