<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dream extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'dreams_id';
    protected $table = 'dreams';
    protected $guarded = array('id');
}
