<?php

use Carbon\Carbon;
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
            'empresa_id'=>1,
            'password' => \Illuminate\Support\Facades\Hash::make("password"),

        ]);
        $role= Role::create(['name' => 'super_admin']);// ejemplo de rol
        $role= Role::create(['name' => 'admin']);// ejemplo de rol
        $role= Role::create(['name' => 'user']);// ejemplo de rol
        $role= Role::create(['name' => 'supervisor']);// ejemplo de rol
        $userSuperAdmin = User::findOrFail(1);// buscan sus usuario
        $userSuperAdmin->assignRole('admin'); // agregan su rol

        $this->call(PerspectivaSeeder::class);
        $this->call(RelacionSeeder::class);

        $this->call(FormulaSeeder::class);
        $this->call(TablaSeeder::class);
        $this->call(CampoSeeder::class);
        DB::table('indicadors')->insert([
            'descripcion' => "descripcion",
            'mecanismo' => "mecanismo",
            'tolerancia' => 5,
            'formula' => "mecanismo",
            'objetivo' => "objetivo",
            'unidad' => "unidad",
            'objeto_medicion' => "objeto",
            'formula_id' => 1,
            'empresa_id' => 1,
            'proceso_id' => 1,
            'personal_id' => 1,

            'condicion1' => 1,
            'condicion2' => 1,
            'condicion3' => 1,

            'campo1_id' => 1,
            'campo2_id' => 2,
            'campo3_id' => 1,

            'tabla1_id' => 1,
            'tabla2_id' => 1,

            'numerador' => "numerador",
            'denominador' => "denominador",
        ]);


DB::table('estados')->insert([
            'descripcion' => "Sin Solucionar",
        ]);
DB::table('estados')->insert([
            'descripcion' => "Solucionado",
        ]);
DB::table('estados')->insert([
            'descripcion' => "Pendiente",
        ]);
DB::table('categorias')->insert([
            'descripcion' => "Cliente",
        ]);
DB::table('categorias')->insert([
            'descripcion' => "Equipo",
        ]);


        for ($i = 1; $i <= 400; $i++) {

            DB::table('incidencias')->insert([
                'descripcion' => "inc",
                'solucion' => "sol",
                'estado' => \App\Estado::findOrFail(rand(1,3))->descripcion,
                'categoria' => \App\Categoria::findOrFail( rand(1,2))->descripcion,
                'empresa_id' => 1,
                'created_at'=>Carbon::today()->subDays(rand(0, 765)),

            ]);

        }
    }
}
