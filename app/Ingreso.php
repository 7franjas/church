<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    //

    public function brother() {
        return $this->belongsTo('App\Brother');
    }

    public function area() {
        return $this->belongsTo('App\Area');
    }
}
