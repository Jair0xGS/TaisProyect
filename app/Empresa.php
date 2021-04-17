<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    function procesos(){
        return $this->hasMany('App\Proceso');
    }
    function mapaProcesos(){
        return $this->hasMany('App\MapaProceso');
    }
    function personals(){
        return $this->hasMany('App\Personal');
    }
}
