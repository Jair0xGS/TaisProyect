<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tablero extends Model
{
    public function indicador()
    {
        return $this->belongsTo('App\Indicador');
    }
}
