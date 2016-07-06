<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Onepage extends Model
{
    protected $primaryKey = 'one_page_id';
    protected $table = 'one_page';
    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo('App\Company','company_id','company');

    }

}
