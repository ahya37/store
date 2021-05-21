<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'users_id','transactions_id','image','banks_id','amount','status_confirmed'
    ];

    protected $append = 'status_label';

    protected $hidden = [];

    public function getStatusLabelAttribute()
    {
        if ($this->status_confirmed == 0) {
            return '<small>(Belum Diterima Admin)</small>';
        }else{
            return '<small>Diterima Admin</small>';
        }
    }
    
}
