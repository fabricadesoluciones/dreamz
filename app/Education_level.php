<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education_level extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */

	protected $table = 'education_levels';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

}
