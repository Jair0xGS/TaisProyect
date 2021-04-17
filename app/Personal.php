<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use SoftDeletes; //Implementamos

    protected $dates = ['deleted_at']; //Registramos la nueva columna

    function puesto(){
        return $this->belongsTo('App\Puesto');
    }
    public function getFullNameAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos. ' - ' . $this->puesto->nombre;
    }

    public function user()
    {
        return $this->hasOne(User::class,'personal_id','id');
    }
}
