<?php

namespace App\Http\Controllers;

use App\Tablero;
use App\Actividad;
use App\CampaniaEtapa;
use App\Estado;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TableroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($campania_id)
    {
        if(Auth::user()->getRoleNames()[0] == 'Director'){
            $actividades = Actividad::
            join('users', 'actividades.usuario_asignado', '=', 'users.id')
            ->join('estados', 'actividades.estado_id', '=', 'estados.id')
            ->select('actividades.id','users.id as user_id','users.name as usuario_encargado', 'users.photo', 'actividades.nombre', 'actividades.descripcion', 'actividades.fecha_entrega', 'actividades.estado_id', 'actividades.etapa_id', 'actividades.campania_id', 'estados.nombre as estado', 'actividades.prioridad as prioridad')
            ->where('campania_id', $campania_id)
            ->get();
            
        } else {
            $actividades = Actividad::
            join('users', 'actividades.usuario_asignado', '=', 'users.id')
            ->select('actividades.id','users.id as user_id','users.name as usuario_asignado', 'actividades.nombre', 'actividades.descripcion', 'actividades.fecha_entrega', 'actividades.estado_id', 'actividades.prioridad as prioridad')
            ->where('campania_id',$campania_id)
            ->where('usuario_asignado',Auth::user()->id)
            ->get();
        }

        $campania_etapas = CampaniaEtapa::
            join('etapas', 'campania_etapas.etapa_id', '=', 'etapas.id')
            ->join('estados', 'campania_etapas.estado_id', '=', 'estados.id')
            ->select('etapas.id','campania_etapas.etapa_id','etapas.nombre', 'etapas.prioridad', 'etapas.url',  'estados.nombre as estado')
            ->where('campania_etapas.campania_id', $campania_id)
            ->get();

        $estados = Estado::where('activo',1)->get();

        $users = User::select('id','name')->get();
        return view('tableros.create', compact('actividades', 'campania_etapas', 'campania_id', 'estados','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tablero  $tablero
     * @return \Illuminate\Http\Response
     */
    public function show(Tablero $tablero)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tablero  $tablero
     * @return \Illuminate\Http\Response
     */
    public function edit(Tablero $tablero)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tablero  $tablero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tablero $tablero)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tablero  $tablero
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tablero $tablero)
    {
        //
    }
}
