<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */

	protected $table = 'departments';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');


    /**
     * Get the users for belonging to this department.
     */
    public function users()
    {
        return $this->hasMany('App\User','department','department_id');
    }

}
