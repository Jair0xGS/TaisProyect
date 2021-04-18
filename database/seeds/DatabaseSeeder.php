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
        $this->call(ProcesoSeeder::class);
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

        $this->call(PerspectivaSeeder::class);
        $this->call(RelacionSeeder::class);

        $this->call(FormulaSeeder::class);
        $this->call(TablaSeeder::class);
        $this->call(CampoSeeder::class);
    }
}
