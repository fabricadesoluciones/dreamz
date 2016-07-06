<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnePageBrandPromiseKPI extends Model
{
    protected $primaryKey = 'one_page_bp_kpis_id';
    protected $table = 'one_page_bp_kpis';
    protected $guarded = ['id'];
}