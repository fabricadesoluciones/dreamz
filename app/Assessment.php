<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;

class Assessment extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'assessment_id';
    protected $table = 'assessments';
    protected $guarded = array('id');
}
