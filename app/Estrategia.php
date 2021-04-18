<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estrategia extends Model
{
    function perspectiva(){
        return $this->belongsTo('App\Perspectiva');
    }
    function relacion(){
        return $this->belongsTo('App\Relacion');
    }
}
