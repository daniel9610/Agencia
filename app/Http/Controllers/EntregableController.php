<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entregable;
use Illuminate\Support\Facades\Auth;

class EntregableController extends Controller
{
    public function store(Request $request)
    {
        $entregable = new Entregable;
        $entregable->nombre = $request->nombre;
        $entregable->descripcion = $request->descripcion;
        $entregable->campania_id = $request->campania_id;
        if($request->etapa_id){
            $entregable->etapa_id = $request->etapa_id;
        }
        if($request->responsable_id){
            $entregable->responsable_id = $request->responsable_id;
        }
        $entregable->estado_id = 1;
        $entregable->fase_id = $request->fase_id;
        $entregable->autor_id = Auth::user()->id;
        $entregable->fecha_entrega = $request->fecha_entrega;
        $entregable->save();

        $m = "Entregable ".$entregable->nombre." creado correctamente";
        return back()->with('success',$m);
    }

    public function asignarResponsable(Request $request)
    {
        $entregable_id = $request->entregable_id;
        $responsable_id = $request->responsable_id;

        $entregable = Entregable::
        where('id', $entregable_id)
        ->first();

        $entregable->responsable_id = $responsable_id;
        $entregable->save();
        // Enviar correo al responsable asignado
        return back()->with('success', 'Responsable asignado correctamente');
    }

    public function update($entregable_id){

    }

    public function edit($entregable_id)
    {

    }

    public function destroy($entregable_id)
    {

    }



}
