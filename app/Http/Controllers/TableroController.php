<?php

namespace App\Http\Controllers;

use App\Tablero;
use App\Actividad;
use App\CampaniaEtapa;
use App\Entregable;
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
        if(Auth::user()->getRoleNames()[0] == 'Director' || Auth::user()->getRoleNames()[0] == 'Director'){
            $actividades = Actividad::
            join('users', 'actividades.usuario_asignado', '=', 'users.id')
            ->join('estados', 'actividades.estado_id', '=', 'estados.id')
            ->select('actividades.id','users.id as user_id','users.name as usuario_encargado', 'users.photo', 'actividades.nombre', 'actividades.descripcion', 'actividades.fecha_entrega', 'actividades.estado_id', 'actividades.etapa_id', 'actividades.campania_id', 'estados.nombre as estado', 'actividades.prioridad as prioridad')
            ->where('campania_id', $campania_id)
            ->orderBy('estados.id', 'asc')
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
        
        $sin_iniciar = 0;
        $en_proceso = 0;
        $en_revision = 0;
        $terminado = 0;
        $en_ajustes = 0;
        $aprobado = 0;

        foreach($actividades as $actividad){
            if($actividad->estado_id == 10){
                $sin_iniciar = $sin_iniciar + 1;
            } else if($actividad->estado_id == 11){
                $en_proceso = $en_proceso + 1;
            } else if($actividad->estado_id == 12){
                $en_revision = $en_revision + 1;
            } else if($actividad->estado_id == 13){
                $terminado = $terminado + 1;
            } else if($actividad->estado_id == 14){
                $en_ajustes = $en_ajustes + 1;
            } else if($actividad->estado_id == 15){
                $aprobado = $aprobado + 1;
            }
        }

        $estados = Estado::where('activo',1)->where('tipo_estado', 3)->get();
        $entregables = Entregable::where('campania_id',$campania_id)->get();

        $users = User::select('id','name')->get();
        // dd($entregables);
        return view('tableros.create', compact(
            'actividades',
            'campania_etapas',
            'campania_id',
            'estados',
            'entregables',
            'users',
            'sin_iniciar',
            'en_proceso',
            'en_revision',
            'terminado',
            'en_ajustes',
            'aprobado'
        ));
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
