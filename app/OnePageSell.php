<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageSell extends Model
{
    protected $primaryKey = 'one_page_sell_id';
    protected $table = 'one_page_sell';
    protected $guarded = ['id'];
}