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
}
