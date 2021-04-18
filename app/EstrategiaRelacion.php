<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstrategiaRelacion extends Model
{
    function estrategia(){
        return $this->belongsTo('App\Estrategia');
    }
}
