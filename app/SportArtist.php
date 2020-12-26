<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SportArtist extends Model
{
    public function sports_artist_track_lists()
    {
    	return $this->hasMany('App\SportMusic','sport_artist_id','id');
    }
}
