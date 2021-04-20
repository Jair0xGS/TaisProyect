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
        DB::table('users')->insert([
            'name' => "Administrador",
            'email' => "admin@admin.com",
            'password' => \Illuminate\Support\Facades\Hash::make("password"),

        ]);
        $this->call(EmpresaSeeder::class);
        $this->call(TipoProcesoSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(ProcesoSeeder::class);

        $role= Role::create(['name' => 'super_admin']);// ejemplo de rol
        $role= Role::create(['name' => 'admin']);// ejemplo de rol
        $role= Role::create(['name' => 'user']);// ejemplo de rol
        $role= Role::create(['name' => 'supervisor']);// ejemplo de rol
        $userSuperAdmin = User::findOrFail(1);// buscan sus usuario
        $userSuperAdmin->assignRole('super_admin'); // agregan su rol

        $this->call(PerspectivaSeeder::class);
        $this->call(RelacionSeeder::class);

        $this->call(FormulaSeeder::class);
        $this->call(TablaSeeder::class);
        $this->call(CampoSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(CategoriaSeeder::class);



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
        $incidenicasEq =[
            [
                "Falla de sensor",
                "Reparacion",
                ],
            [
                "Falla de impresora",
                "Reparacion",
                ],
            [
                "Falla de camara",
                "Reparacion",
                ],
            [
                "Falla de monitor",
                "Reparacion",
                ],

        ];
 $incidenicasClie =[
            [
                "Queja Mala Atencion",
                "Solucion de queja",
                ],[
                "Tardanza en Atencion",
                "Hablar con personal",
                ],

        ];

        for ($i = 1; $i <= 100; $i++) {

            DB::table('incidencias')->insert([
                'descripcion' => $incidenicasEq[rand(0,count($incidenicasEq)-1)][0],
                'solucion' =>  $incidenicasEq[rand(0,count($incidenicasEq)-1)][1],
                'estado' => \App\Estado::findOrFail(rand(1,3))->descripcion,
                'categoria' => \App\Categoria::findOrFail(2)->descripcion,
                'empresa_id' => rand(1,2),
                'created_at'=>Carbon::today()->subDays(rand(0, 765)),

            ]);

        }
        for ($i = 1; $i <= 100; $i++) {

            DB::table('incidencias')->insert([
                'descripcion' => $incidenicasClie[rand(0,count($incidenicasClie)-1)][0],
                'solucion' =>  $incidenicasClie[rand(0,count($incidenicasClie)-1)][1],
                'estado' => \App\Estado::findOrFail(rand(1,3))->descripcion,
                'categoria' => \App\Categoria::findOrFail(1)->descripcion,
                'empresa_id' => rand(1,2),
                'created_at'=>Carbon::today()->subDays(rand(0, 765)),

            ]);

        }
    }
}
