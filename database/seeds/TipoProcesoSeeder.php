<?php

use Illuminate\Database\Seeder;

class TipoProcesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_procesos')->insert([
            'tipo' => "Estrategicos",
        ]);
        DB::table('tipo_procesos')->insert([
            'tipo' => "Primarios",
        ]);
        DB::table('tipo_procesos')->insert([
            'tipo' => "De Apoyo",
        ]);
    }
}
