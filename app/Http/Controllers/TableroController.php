<?php

namespace App\Http\Controllers;

use App\Tablero;
use App\Actividad;
use App\CampaniaEtapa;
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
            where('campania_id',$campania_id)
            ->get();
        } else {
            $actividades = Actividad::
            where('campania_id',$campania_id)
            ->where('usuario_asignado',Auth::user()->id)
            ->get();
        }

        $campania_etapas = CampaniaEtapa::
            join('etapas', 'campania_etapas.etapa_id', '=', 'etapas.id')
            ->join('estados', 'campania_etapas.estado_id', '=', 'estados.id')
            ->select('etapas.id','campania_etapas.etapa_id','etapas.nombre', 'etapas.prioridad', 'etapas.url',  'estados.nombre as estado')
            ->where('campania_etapas.campania_id', $campania_id)
            ->get();

        return view('tableros.create', compact('actividades', 'campania_etapas'));
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
