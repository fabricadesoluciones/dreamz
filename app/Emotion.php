<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emotion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'emotion_id';
    protected $table = 'emotions';
    protected $guarded = array('id');
}
