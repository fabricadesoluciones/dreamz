<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActiveEmotion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'active_emotion_id';
    protected $table = 'active_emotions';

}
