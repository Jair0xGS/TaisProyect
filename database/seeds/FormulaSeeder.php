<?php

use Illuminate\Database\Seeder;

class FormulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formulas = [
            [
                "Complemento (%)",
            ],[
                "Razón porcentual",
            ],[
                "Sumatoria simple",
            ],

        ];

        foreach ($formulas as $formula) {
            DB::table('formulas')->insert([
                'descripcion' => $formula[0],
            ]);
        }
    }
}
