<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjectiveProgress extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */

    protected $primaryKey = 'objective_progress_id';
	protected $table = 'objectives_progress';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

}
