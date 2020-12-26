<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $table = 'seos';
    protected $primaryKey = 'seo_id';
    public $timestamps = true;
    protected $guarded = [];
}
