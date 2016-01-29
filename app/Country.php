<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

	/**
     * The database table used by the model.
     *
     * @var string
     */

    protected $primaryKey = 'country_id';
    protected $table = 'countries';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $dates = ['deleted_at'];

}
