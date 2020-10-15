<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;
use App\User;

class RolController extends Controller
{
    public function vistaRoles(){
        $users = User::doesntHave('roles')->get();
        $roles = Role::all();
        return view('roles.assign', compact('users', 'roles'));
    }

    public function asignarRoles(Request $request){
        $user_id = $request->user_id;
        $nombre_rol = $request->nombre_rol;
        // $objeto_rol = Role::where('id', $nombre_rol)->get();
        // dd();
        // $rol = $objeto_rol->name;

        $user = User::find($user_id);
        $user->assignRole($nombre_rol);
        return redirect()->back()->with('success', 'Rol asignado correctamente');
    }
}
