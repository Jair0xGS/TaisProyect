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
                "white",
            ],[
                "Estrategias fuera del alcance del proceso",
                "#A9B3F6",
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
