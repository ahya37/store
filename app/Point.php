<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = [
        'users_id','nominal_point','amount_point'
    ];

    protected $hidden = [];

    public function user()
    {
        return $this->hasOne(User::class,'id','users_id');
    }
}
