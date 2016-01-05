<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeasuringUnit extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */

    protected $primaryKey = 'measuring_unit_id';
    protected $table = 'measuring_units';


	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

}
