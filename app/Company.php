<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */

	protected $table = 'companies';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * Get the users for belonging to this company.
     */
    public function users()
    {
        return $this->hasMany('App\User','company','company_id');
        return $this->hasMany('App\Department','company','company_id');
    }

}
