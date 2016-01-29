<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priority extends Model
{
    use SoftDeletes;

	/**
     * The database table used by the model.
     *
     * @var string
     */

	protected $table = 'priorities';

	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $dates = ['deleted_at'];

    /**
     * Get the period.
     */
    
    public function get_period()
    {
        return $this->belongsTo('App\Period','period','period_id');

    }
}
