<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObjectiveCategory extends Model
{
    use SoftDeletes;


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
    protected $dates = ['deleted_at'];
    

}
