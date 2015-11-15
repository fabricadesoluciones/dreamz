<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */

	protected $table = 'positions';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * Get the users for belonging to this position.
     */
    public function users()
    {
        return $this->hasMany('App\User','position','position_id');
    }


}
