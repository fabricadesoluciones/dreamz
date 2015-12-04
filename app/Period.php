<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */

	protected $table = 'periods';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

}