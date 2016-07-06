<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageColaborator extends Model
{
    protected $primaryKey = 'one_page_colaborators_id';
    protected $table = 'one_page_colaborators';
    protected $guarded = ['id'];
}