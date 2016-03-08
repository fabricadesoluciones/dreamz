<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

	/**
     * The database table used by the model.
     *
     * @var string
     */

	protected $table = 'companies';
    protected $primaryKey = 'company_id';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $dates = ['deleted_at'];

    /**
     * Get the users for belonging to this company.
     */
    public function users()
    {
        return $this->hasMany('App\User','company','company_id');
    }

    /**
     * Get the departments for belonging to this company.
     */
    public function departments()
    {
        return $this->hasMany('App\Department','company','company_id');
    }

    /**
     * Get the positions for belonging to this company.
     */
    public function positions()
    {
        return $this->hasMany('App\Position','company','company_id');
    }

    public function virtues()
    {
        return $this->hasMany('App\Virtue','company','company_id');
    }
}
