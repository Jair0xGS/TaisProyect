<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MapaEstrategico extends Model
{
    function estrategias(){
        return $this->hasMany('App\Estrategia',"mapa_estrategico_id","id");
    }
}
