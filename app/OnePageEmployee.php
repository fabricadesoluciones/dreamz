<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageEmployee extends Model
{
    protected $primaryKey = 'one_page_employees_id';
    protected $table = 'one_page_employees';
    protected $guarded = ['id'];
}