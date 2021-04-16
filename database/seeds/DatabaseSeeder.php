<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmpresaSeeder::class);
        $this->call(TipoProcesoSeeder::class);
        DB::table('users')->insert([
            'name' => "Administrador",
            'email' => "admin@admin.com",
            'password' => \Illuminate\Support\Facades\Hash::make("password"),

        ]);
    }
}
