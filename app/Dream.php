<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dream extends Model
{
	use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'dreams_id';
    protected $table = 'dreams';
    protected $guarded = array('id');
    protected $dates = ['deleted_at'];
}
