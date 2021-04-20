<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    public function personal(){
        return $this->belongsTo('App\Personal');
    }

    public function formulaa(){
        return $this->belongsTo('App\Formula','formula_id','id');
    }

    public function tableros(){
        return $this->hasMany('App\Tablero');
    }

    public function tabla1(){
        return $this->belongsTo('App\Tabla','tabla1_id','id');
    }

    public function tabla2(){
        return $this->belongsTo('App\Tabla','tabla2_id','id');
    }

    public function campo1(){
        return $this->belongsTo('App\Campo','campo1_id','id');
    }

    public function campo2(){
        return $this->belongsTo('App\Campo','campo2_id','id');
    }
    public function campo3(){
        return $this->belongsTo('App\Campo','campo3_id','id');
    }


}
