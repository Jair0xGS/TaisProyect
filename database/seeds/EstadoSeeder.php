<?php

use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estados')->insert([
            'descripcion' => 'Por atender',
        ]);
        DB::table('estados')->insert([
            'descripcion' => 'Solucionado',
        ]);
        DB::table('estados')->insert([
            'descripcion' => 'Sin solucionar',
        ]);
    }
}
