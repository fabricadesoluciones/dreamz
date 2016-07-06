<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageAction extends Model
{
    protected $primaryKey = 'one_page_action_id';
    protected $table = 'one_page_actions';
    protected $guarded = ['id'];
}