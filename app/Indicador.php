<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    function personal(){
        return $this->belongsTo('App\Personal');
    }
}
