<?php

use Illuminate\Database\Seeder;

class PerspectivaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param $perspectiva
     * @return void
     */
    public function run()
    {
        $perspectivas = [
            [
                "Financiera",
                "green",
            ],
            [
                "Clientes",
                "yellow",
            ],
            [
                "Procesos Internos",
                "orange",
            ],
            [
                "Aprendisaje y Crecimiento",
                "blue",
            ],
        ];

        foreach ($perspectivas as $perspectiva) {
            DB::table('perspectivas')->insert([
                'nombre' => $perspectiva[0],
                'color'=>  $perspectiva[1],
            ]);
        }


    }
}
