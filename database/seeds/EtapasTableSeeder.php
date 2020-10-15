<?php

use Illuminate\Database\Seeder;

class EtapasTableSeeder extends Seeder
{
    /**

     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Etapa::create([
            'nombre'      => 'Generar brief',
            'prioridad'     => 'alto',
            'url'     => 'generar-brief',
        ]);

        App\Etapa::create([
            'nombre'      => 'Realizar KickOff',
            'prioridad'     => 'alto',
            'url'     => 'kickoff',
        ]);

        App\Etapa::create([
            'nombre'      => 'Generar investigación de brief',
            'prioridad'     => 'alto',
            'url'     => 'generar-investigacion-brief',
        ]);

        App\Etapa::create([
            'nombre'      => 'Generar y alinear estrategia',
            'prioridad'     => 'alto',
            'url'     => 'generar-alinear-estrategia',
        ]);

        App\Etapa::create([
            'nombre'      => 'Generar creatividad',
            'prioridad'     => 'medio',
            'url'     => 'generar-creatividad',
        ]);

        App\Etapa::create([
            'nombre'      => 'Planear ejecución',
            'prioridad'     => 'alto',
            'url'     => 'planear-ejecucion',
        ]);

    }
}