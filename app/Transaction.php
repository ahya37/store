<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
     protected $fillable = [
        'users_id',
        'inscurance_price',
        'shipping_price',
        'total_price',
        'transaction_status',
        'code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class,'users_id','id');
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class,'transactions_id','id');
    }
}
