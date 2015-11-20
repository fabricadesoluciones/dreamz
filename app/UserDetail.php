<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{

	/**
     * The database table used by the model.
     *
     * @var string
     */

	protected $table = 'user_details';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');


}
