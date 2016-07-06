<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OneBHAG extends Model
{
    protected $primaryKey = 'one_page_bhag_id';
    protected $table = 'one_page_bhag';
    protected $guarded = ['id'];
}