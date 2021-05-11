<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdCard extends Model
{
    protected $table    = 'idcard';
    protected $fillable = [
        'file','users_id'
    ];


    protected $hidden = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id','users_id');
    }
}
