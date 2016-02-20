<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObjectiveProgress extends Model
{
    use SoftDeletes;

	/**
     * The database table used by the model.
     *
     * @var string
     */

    protected $primaryKey = 'objectives_progress_id';
	protected $table = 'objectives_progress';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $dates = ['deleted_at'];

}
