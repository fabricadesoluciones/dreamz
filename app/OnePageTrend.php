<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageTrend extends Model
{
    protected $primaryKey = 'one_page_trends_id';
    protected $table = 'one_page_trends';
    protected $guarded = ['id'];
}