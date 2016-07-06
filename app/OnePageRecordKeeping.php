<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageRecordKeeping extends Model
{
    protected $primaryKey = 'one_page_recrod_keeping_id';
    protected $table = 'one_page_record_keeping';
    protected $guarded = ['id'];
}