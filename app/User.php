<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use 
    Authenticatable,
    CanResetPassword,
    EntrustUserTrait,
    SoftDeletes;



    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id','remember_token','created_at','updated_at');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    protected $dates = ['deleted_at'];

    public function position()
    {
        return $this->belongsTo('App\Position','position_id','position');

    }
    public function company()
    {
        return $this->belongsTo('App\Company','company_id','company');
    }

    public function details()
    {
        return $this->hasOne('App\UserDetail','user_id','user');
    }

    public function priorities()
    {
        return $this->hasMany('App\Priority','user','user_id');
    }

    public function objectives()
    {
        return $this->hasMany('App\Objective','user','user_id');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task','user','user_id');
    }

}
