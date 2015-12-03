<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
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

    /**
     * Get the period.
     */
    
    public function get_period()
    {
        return $this->belongsTo('App\Period','period','period_id');

    }
}
