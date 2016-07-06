<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageMakeBuy extends Model
{
    protected $primaryKey = 'one_page_make_buy_id';
    protected $table = 'one_page_make_buy';
    protected $guarded = ['id'];
}