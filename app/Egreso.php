<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egreso extends Model
{
    //

    public function brother() {
        return $this->belongsTo('App\Brother');
    }

    public function area() {
        return $this->belongsTo('App\Area');
    }

    public function subarea() {
        return $this->belongsTo('App\Subarea');
    }
}
