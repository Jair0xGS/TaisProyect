<?php

use Illuminate\Database\Seeder;

class ProcesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $procesos = [
            [
                "Provision de materiales",
                [
                    "Determinacion de la necesidad de materias primas",
                    "Contacto con proveedores y compra",
                    "Gestion de Almacenaje del material",
                    "Repcion de documentacion, facturas y pago",
                ],
            ],
            [
                "Captaciones",
                [
                    "Ejecutar procdesos de captacion",
                    "Evaluar solicitud de producto",
                    "Capacitar Personal",
                    "Afiliar Cliente",
                ],
            ],
            [
                "Gestion de Riesgos",
                [
                    "Realizar Seguimiento de Portafolio",
                    "Gestionar Fondeo Financiero",
                    "Gestionar limite de efectivo",
                    "Gestionar politicas crediticias",
                    "Evaluar solicitud de credito",
                    "Afiliar Cliente",
                    "Gestionar Solicitud de Cliente",
                ],
            ],

        ];

        $empresas  = \App\Empresa::all();
        $tipos= \App\TipoProceso::all();
        foreach ($empresas as $empresa){
            for($i = 0; $i < rand(1,count($procesos)); ++$i) {
                $id = DB::table('procesos')->insertGetId([
                    'nombre' => $procesos[$i][0],
                    'empresa_id'=>$empresa->id,
                    'tipo_proceso_id'=>$tipos->random()->id,
                    'personal_id'=> $empresa->personals->random()->id,
                ]);
                for($j = 0; $j < rand(1,count($procesos[$i][1])); ++$j) {
                    DB::table('procesos')->insert([
                        'nombre' => $procesos[$i][1][$j],
                        'empresa_id'=>$empresa->id,
                        'proceso_id'=> $id,
                        'personal_id'=> $empresa->personals->random()->id,
                    ]);

                }

            }

        }
    }
}
