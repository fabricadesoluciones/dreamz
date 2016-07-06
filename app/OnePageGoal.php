<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageGoal extends Model
{
    protected $primaryKey = 'one_page_goals_id';
    protected $table = 'one_page_goals';
    protected $guarded = ['id'];
}