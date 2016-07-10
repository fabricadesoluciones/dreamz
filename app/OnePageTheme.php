<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageTheme extends Model
{
    protected $primaryKey = 'one_page_theme_id';
    protected $table = 'one_page_theme';
    protected $guarded = ['id'];
}