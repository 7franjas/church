<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{

    use SoftDeletes;
    /**
     * SoftDelete atribbute
     */
    protected $dates = ['deleted_at'];


    protected $table = 'family';
}
