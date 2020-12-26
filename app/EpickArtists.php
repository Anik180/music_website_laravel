<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EpickArtists extends Model
{
    public $timestamps = false;

    public function track_lists()
    {
    	return $this->hasMany('App\TrackList','epic_artists_id','id');
    }
}
