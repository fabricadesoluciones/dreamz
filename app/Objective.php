<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */

    protected $primaryKey = 'objective_id';
    protected $table = 'objectives';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

}
