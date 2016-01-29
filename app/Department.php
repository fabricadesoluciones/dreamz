<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
	/**
     * The database table used by the model.
     *
     * @var string
     */

	protected $table = 'departments';
    protected $primaryKey = 'department_id';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $dates = ['deleted_at'];

    /**
     * Get the users for belonging to this department.
     */
    public function users()
    {
        return $this->hasMany('App\User','department','department_id');
    }

}
