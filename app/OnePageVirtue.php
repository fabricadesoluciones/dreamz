<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageVirtue extends Model
{
    protected $primaryKey = 'one_page_virtue_id';
    protected $table = 'one_page_virtues';
    protected $guarded = ['id'];
}