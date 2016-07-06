<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageKeyInitiative extends Model
{
    protected $primaryKey = 'one_page_key_initiatives_id';
    protected $table = 'one_page_key_initiatives';
    protected $guarded = ['id'];
}