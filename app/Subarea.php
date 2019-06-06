<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subarea extends Model
{
    protected $table = 'subarea';
    
    public function area() {
        return $this->belongsTo('App\Area');
    }
}
