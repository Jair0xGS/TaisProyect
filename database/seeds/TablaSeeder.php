<?php

use Illuminate\Database\Seeder;

class TablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('tablas')->insert([
                'nombre' => 'incidencias',
            ]);
    }
}
