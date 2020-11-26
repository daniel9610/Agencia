<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Permission list
        Permission::create(['name' => 'campanias.index']);
        Permission::create(['name' => 'campanias.edit']);
        Permission::create(['name' => 'campanias.show']);
        Permission::create(['name' => 'campanias.create']);
        Permission::create(['name' => 'campanias.destroy']);

        Permission::create(['name' => 'activities.index']);
        Permission::create(['name' => 'activities.edit']);
        Permission::create(['name' => 'activities.show']);
        Permission::create(['name' => 'activities.create']);
        Permission::create(['name' => 'activities.destroy']);


        //Director
        $director = Role::create(['name' => 'Director']);

        $director->givePermissionTo([
            'campanias.index',
            'campanias.edit',
            'campanias.show',
            'campanias.create',
            'campanias.destroy',
            'activities.index',
            'activities.edit',
            'activities.show',
            'activities.create',
            'activities.destroy'
        ]);

        //PMO
        $pmo = Role::create(['name' => 'PMO']);

        $pmo->givePermissionTo([
            'campanias.index',
            'campanias.show',
            'activities.index',
            'activities.edit',
            'activities.show',
            'activities.create',
            'activities.destroy'
        ]);

        //Líder de investigación
        $lider_investigacion = Role::create(['name' => 'Líder de investigación']);

        $lider_investigacion->givePermissionTo([
            'campanias.index',
            'campanias.show',
            'activities.index',
            'activities.edit',
            'activities.show',
            'activities.create',
            'activities.destroy'
        ]);

        // Líder de creatividad
        $lider_creatividad = Role::create(['name' => 'Lider de creatividad']);

        $lider_creatividad->givePermissionTo([
            'campanias.index',
            'campanias.show',
            'activities.index',
            'activities.edit',
            'activities.show',
            'activities.create',
            'activities.destroy'
        ]);
        //$director->givePermissionTo('campanias.index');
        //$director->givePermissionTo(Permission::all());
       
        //Talento
        $talento = Role::create(['name' => 'Talento']);

        $talento->givePermissionTo([
            'campanias.index',
            'campanias.show',
            'activities.index',
            'activities.edit'
        ]);

        // Cliente
        $cliente = Role::create(['name' => 'Cliente']);

        $cliente->givePermissionTo([
            
        ]);

        //User Director
        $user = User::find(1); //El primer usuario tendrá rol de Director (admin)
        $user->assignRole('Director');
    }
}