<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
    use SoftDeletes;
	/**
     * The database table used by the model.
     *
     * @var string
     */

    protected $primaryKey = 'position_id';
	protected $table = 'positions';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $dates = ['deleted_at'];

    /**
     * Get the users for belonging to this position.
     */
    public function users()
    {
        return $this->hasMany('App\User','position','position_id');
    }


}
