<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brother extends Model
{
    use SoftDeletes;
    /**
     * SoftDelete atribbute
     */
    protected $dates = ['deleted_at'];


    public function family() {
        return $this->belongsTo('App\Family');
    }
    
}
