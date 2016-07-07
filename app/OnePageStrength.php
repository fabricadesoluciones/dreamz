<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageStrength extends Model
{
    protected $primaryKey = 'one_page_strengths_id';
    protected $table = 'one_page_strengths';
    protected $guarded = ['id'];
}