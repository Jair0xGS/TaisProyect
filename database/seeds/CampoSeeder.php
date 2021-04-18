<?php

use Illuminate\Database\Seeder;

class CampoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('campos')->insert([
            'nombre' => 'estado',
            'tabla_id' => 1,
        ]);
        DB::table('campos')->insert([
            'nombre' => 'categoria',
            'tabla_id' => 1,
        ]);
    }
}
