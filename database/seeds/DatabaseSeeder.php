<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;

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
        $this->call(AreaSeeder::class);
        DB::table('users')->insert([
            'name' => "Administrador",
            'email' => "admin@admin.com",
            'password' => \Illuminate\Support\Facades\Hash::make("password"),

        ]);
        $role= Role::create(['name' => 'super_admin']);// ejemplo de rol
        $role= Role::create(['name' => 'admin']);// ejemplo de rol
        $role= Role::create(['name' => 'user']);// ejemplo de rol
        $userSuperAdmin = User::findOrFail(1);// buscan sus usuario
        $userSuperAdmin->assignRole('super_admin'); // agregan su rol

        DB::table('personals')->insert([
            'nombres' => "jose",
            'apellidos' => "jose",
            'correo' => "jose@garcia.coom",
            'telefono' => "234234",
            'puesto_id' => 1,

        ]);

    }
}
