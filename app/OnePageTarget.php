<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageTarget extends Model
{
    protected $primaryKey = 'one_page_target_id';
    protected $table = 'one_page_targets';
    protected $guarded = ['id'];
}