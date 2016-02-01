<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObjectiveSubcategory extends Model
{
    use SoftDeletes;


	/**
     * The database table used by the model.
     *
     * @var string
     */

    protected $primaryKey = 'subcategory_id';
    protected $table = 'objective_subcategories';


	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $dates = ['deleted_at'];
    

}
