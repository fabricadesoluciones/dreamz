<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DreamSubcategory extends Model
{
    use SoftDeletes;


	/**
     * The database table used by the model.
     *
     * @var string
     */

    protected $primaryKey = 'subcategory_id';
    protected $table = 'dreams_subcategories';


	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $dates = ['deleted_at'];
    

}
