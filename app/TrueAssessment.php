<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;

class TrueAssessment extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'true_assessment_id';
    protected $table = 'true_assessments';
    protected $guarded = array('id');
}
