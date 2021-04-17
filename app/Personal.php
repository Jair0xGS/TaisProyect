<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{

    function puesto(){
        return $this->belongsTo('App\Puesto');
    }
    public function getFullNameAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos. ' - ' . $this->puesto->nombre;
    }
}
