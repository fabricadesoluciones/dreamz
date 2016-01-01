<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjectiveCategory extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */

    protected $primaryKey = 'category_id';
    protected $table = 'objective_categories';


	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

}
