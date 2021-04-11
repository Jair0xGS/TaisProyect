<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    function tipo(){
        return $this->hasMany('App\TipoProceso');
    }
}
