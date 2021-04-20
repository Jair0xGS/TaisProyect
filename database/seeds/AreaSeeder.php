<?php

use App\Personal;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Populate the pivot table
        $areas = [
            [
                "Produccion",
                [
                    "Jefe de Produccion",
                    "Personal tecnico especializado",
                    "Analista de calidad",
                    "Supervisor de fabrica",
                ]
            ],
            [
                "Informatica",
                [
                    "Desarrollador de sistemas",
                    "Programador",
                    "Servicio Tecnico",
                    "Auditor Informatico",
                ]
            ],
            [
                "Marketing",
                [
                    "Social Media Manager",
                    "SEO",
                    "Redactor",
                ]
            ],
            [
                "Auditoria",
                [
                    "Control de procesos",
                    "Analisis de procesos",
                    "Control Interno",
                ]
            ],
            [
                "Finanzas",
                [
                    "Control financiero",
                    "Pagos",
                    "Estados financieros",
                ]
            ],
            [
                "Distribucion",
                [
                    "Transporte",
                    "Almacenaje",
                ]
            ],
            [
                "RRHH",
                [
                    "Reclutamiento",
                    "Formacion",
                    "Relaciones Laborales",
                ]
            ],
        ];

        $empresas  = \App\Empresa::all();
        foreach ($empresas as $empresa){
            for($i = 0; $i < rand(1,count($areas)); ++$i) {
                $id = DB::table('areas')->insertGetId([
                    'nombre' => $areas[$i][0],
                    'empresa_id'=>$empresa->id,
                ]);
                for($j = 0; $j < rand(1,count($areas[$i][1])); ++$j) {
                    $pid=  DB::table('puestos')->insertGetId([
                        'nombre' => $areas[$i][1][$j],
                        'area_id'=> $id,
                    ]);
                    $faker = \Faker\Factory::create();
                    $personalID =DB::table('personals')->insertGetId([
                        'nombres' => $faker->firstName,
                        'apellidos'=>  $faker->lastName,
                        'telefono'=>  $faker->phoneNumber,
                        'correo'=>  $faker->safeEmail,
                        'puesto_id'=>  $pid,
                        'empresa_id'=>  $empresa->id,


                    ]);
                    $personal = Personal::findOrFail($personalID);
                    DB::table('users')->insert([
                        'name' => $personal->nombres,
                        'email' => $personal->correo,
                        'empresa_id' =>$empresa->id,
                        'personal_id' =>$personal->id,
                        'email_verified_at' => now(),
                        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                        'remember_token' => Str::random(10),
                    ]);
                }

            }

        }
    }
}
