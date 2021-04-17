<?php

use Illuminate\Database\Seeder;

class RelacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relaciones = [
            [
                "Estrategias Propias del proceso",
                "green",
            ],[
                "Estrategias fuera del alcance del proceso",
                "green",
            ],[
                "Estrategias Generales del negocio",
                "green",
            ],

        ];

        foreach ($relaciones as $relacion) {
            DB::table('relacions')->insert([
                'nombre' => $relacion[0],
                'color'=>  $relacion[1],
            ]);
        }
    }
}
