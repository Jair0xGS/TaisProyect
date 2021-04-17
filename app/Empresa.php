<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    function procesos(){
        return $this->hasMany('App\Proceso');
    }
    function personals(){
        return $this->hasMany('App\Personal');
    }
}
