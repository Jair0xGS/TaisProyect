<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    function tipoProceso(){
        return $this->belongsTo('App\TipoProceso');
    }
    function personal(){
        return $this->belongsTo('App\Personal');
    }
    function procesos(){
        return $this->hasMany('App\Proceso',"proceso_id","id");
    }
    function mapaEstrategico(){
        return $this->hasMany('App\MapaEstrategico',"proceso_id","id");
    }
    function indicadores(){
        return $this->hasMany('App\Indicador',"proceso_id","id");
    }
}
