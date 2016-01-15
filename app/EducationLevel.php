<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */

	protected $table = 'education_levels';
    protected $primaryKey = 'education_level_id';
    

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

}
