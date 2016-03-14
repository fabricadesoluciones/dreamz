<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Virtue extends Model
{
    protected $primaryKey = 'virtue_id';
    protected $table = 'virtues';
    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo('App\Company','company_id','company');

    }

    public function virtue_givers()
    {
        return $this->hasMany('App\VirtueGiver', 'virtue','virtue_id');
    }
}
