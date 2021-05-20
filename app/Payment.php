<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'users_id','transactions_id','image','banks_id','amount'
    ];

    protected $hidden = [];
}
