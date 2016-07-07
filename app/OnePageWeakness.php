<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageWeakness extends Model
{
    protected $primaryKey = 'one_page_weaknesses_id';
    protected $table = 'one_page_weaknesses';
    protected $guarded = ['id'];
}