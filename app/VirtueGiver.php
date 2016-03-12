<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VirtueGiver extends Model
{
    protected $primaryKey = 'given_virtue_id';
    protected $table = 'given_virtues';
    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo('App\Company','company_id','company');

    }

}
