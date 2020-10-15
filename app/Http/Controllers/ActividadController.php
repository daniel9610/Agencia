<?php

namespace App\Http\Controllers;

use App\Actividad;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->campania_id);
        $actividad = new Actividad;
        $actividad->nombre = $request->nombre;
        $actividad->prioridad = $request->prioridad;
        $actividad->campania_id = $request->campania_id;
        $actividad->etapa_id = $request->etapa_id;
        // $actividad->gant_id = $request->gant_id;
        $actividad->estado_id = $request->estado_id;
        $actividad->fecha_entrega = $request->fecha_entrega;
        $actividad->save();
        $m = "Actividad ".$actividad->nombre." creada correctamente";
        return back()->with('status',$m);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function show(Actividad $actividad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function edit(Actividad $actividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */

    // Asignación de actividades
    public function update(Request $request, $id)
    {
        $fecha = Carbon::now();
        $actividad = Actividad::findOrFail($request->actividad_id);
        $actividad->autor_id = Auth::user()->id;
        $actividad->usuario_asignado = $request->usuario_asignado;
        $actividad->fecha_asignacion = $fecha->toDateTimeString();
        $actividad->save();
        $m = "Actividad ".$actividad->nombre." asignada correctamente"; 
        return back()->with('status',$m);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actividad $actividad)
    {
        //
    }
}
