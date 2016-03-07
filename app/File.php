<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $primaryKey = 'file_id';
    protected $table = 'files';
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo('App\User','user_id','user');

    }
}
