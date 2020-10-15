<?php

use Illuminate\Database\Seeder;

class EstadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Estado::create([
            'nombre'      => 'Inicializado',
            'tipo_estado'     => '2',
            'activo'     => '1',
        ]);

        App\Estado::create([
            'nombre'      => 'Finalizado',
            'tipo_estado'     => '2',
            'activo'     => '1',
        ]);

        App\Estado::create([
            'nombre'      => 'En espera de brief diligenciado',
            'tipo_estado'     => '1',
            'activo'     => '1',
        ]);

        App\Estado::create([
            'nombre'      => 'Brief diligenciado',
            'tipo_estado'     => '1',
            'activo'     => '1',
        ]);

        App\Estado::create([
            'nombre'      => 'En ajustes de brief por parte del cliente',
            'tipo_estado'     => '1',
            'activo'     => '1',
        ]);

        App\Estado::create([
            'nombre'      => 'Brief ajustado',
            'tipo_estado'     => '1',
            'activo'     => '1',
        ]);

        App\Estado::create([
            'nombre'      => 'Brief completo por parte del cliente',
            'tipo_estado'     => '1',
            'activo'     => '1',
        ]);

        App\Estado::create([
            'nombre'      => 'Sin iniciar',
            'tipo_estado'     => '3',
            'activo'     => '1',
        ]);

        App\Estado::create([
            'nombre'      => 'En proceso',
            'tipo_estado'     => '3',
            'activo'     => '1',
        ]);

        App\Estado::create([
            'nombre'      => 'En revisión',
            'tipo_estado'     => '3',
            'activo'     => '1',
        ]);

        App\Estado::create([
            'nombre'      => 'Terminado',
            'tipo_estado'     => '3',
            'activo'     => '1',
        ]);

        App\Estado::create([
            'nombre'      => 'En ajustes',
            'tipo_estado'     => '3',
            'activo'     => '1',
        ]);

        App\Estado::create([
            'nombre'      => 'Aprobado',
            'tipo_estado'     => '3',
            'activo'     => '1',
        ]);
    }
}
