<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = "activities";

    protected $fillable = ['name', 'start', 'end'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
