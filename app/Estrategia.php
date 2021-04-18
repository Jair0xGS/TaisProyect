<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estrategia extends Model
{
    function perspectiva(){
        return $this->belongsTo('App\Perspectiva');
    }
    function estrategias(){
        return $this->hasMany("App\EstrategiaRelacion");
    }
    function relacion(){
        return $this->belongsTo('App\Relacion');
    }
}
