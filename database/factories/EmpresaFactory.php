<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Empresa;
use Faker\Generator as Faker;

$factory->define(Empresa::class, function (Faker $faker) {
    return [
        'descripcion'=>$faker->company,
        'ruc'=>strval($faker->randomNumber(10)),
        'nombre'=>$faker->name,
        'telefono'=>$faker->phoneNumber,
        'email'=>$faker->companyEmail,
        'direccion'=>$faker->address,
    ];
});
