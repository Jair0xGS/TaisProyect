<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //

    public function puestos()
    {
        return $this->hasMany(Puesto::class, 'area_id', 'id');
    }
}
