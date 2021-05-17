<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdCard extends Model
{
    protected $table    = 'idcard';
    protected $append   = ['status_label'];
    protected $fillable = [
        'file','users_id','status'
    ];


    protected $hidden = [];

    public function getStatusLabelAttribute()
    {
        if ($this->status == 0) {
            return '<span>Persetujuan Pending</span>';
        }
            return '<span>Disetujui</span>';
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id','users_id');
    }
    
}
