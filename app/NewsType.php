<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsType extends Model
{
    protected $table = 'news_types';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];
}
