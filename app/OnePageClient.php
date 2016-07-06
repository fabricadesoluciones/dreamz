<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageClient extends Model
{
    protected $primaryKey = 'one_page_customers_id';
    protected $table = 'one_page_customers';
    protected $guarded = ['id'];
}