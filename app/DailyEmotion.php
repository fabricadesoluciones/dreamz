<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyEmotion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'daily_emotion_id';
    protected $table = 'daily_emotions';
    public $timestamps = false;
    protected $guarded = array('id');
}
