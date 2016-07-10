<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageReward extends Model
{
    protected $primaryKey = 'one_page_celebration_id';
    protected $table = 'one_page_celebration';
    protected $guarded = ['id'];
}
