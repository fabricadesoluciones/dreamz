<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OneCriticalNumber extends Model
{
    protected $primaryKey = 'one_page_key_criticals_id';
    protected $table = 'one_page_critical_numbers';
    protected $guarded = ['id'];
}