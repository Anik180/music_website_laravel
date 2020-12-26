<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drtv extends Model
{
    public function dr_tv_track_lists()
    {
    	return $this->hasMany('App\DrtvMusic','drtv_id','id');
    }
}
