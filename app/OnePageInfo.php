<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageInfo extends Model
{
    protected $primaryKey = 'one_page_general_info_id';
    protected $table = 'one_page_general_info';
    protected $guarded = ['id'];
}