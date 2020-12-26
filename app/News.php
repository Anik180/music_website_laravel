<?php

namespace App;
use App\News;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    
    public function setTitleAttribute($value)
    {
    	$this->attributes['title'] = $value;
    	$this->attributes['url'] = $this->urlGenerate($value);
    }

    private function urlGenerate($value)
    {
    	$url = str_replace(' ','-',strtolower($value));
    	$count = News::where('url','LIKE',$url.'%')->count();
    	$suffix = $count ? $count+1 : '';
    	$url .= $suffix;
    	return $url;
    }

}
