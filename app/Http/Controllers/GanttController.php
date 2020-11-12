<?php

namespace App\Http\Controllers;

use App\Campania;
use App\Etapa;
use App\CampaniaEtapa;
use App\Actividad;

use Illuminate\Http\Request;

class GanttController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campanias = Campania::all();
        $etapas = Etapa::all();
        $campania_etapas = CampaniaEtapa::
        join('campanias','campanias.id','=','campania_etapas.campania_id')
        ->join('etapas','etapas.id','=','campania_etapas.etapa_id')
        ->get();

        $actividades = Actividad::
        join('users', 'users.id', '=', 'actividades.usuario_asignado')
        ->join('estados','estados.id', '=', 'actividades.estado_id')
        ->select('actividades.*', 'users.name as name','estados.porcentaje as porcentaje')
        ->get();

        return view('gantt.index', compact(
            'campanias',
            'etapas',
            'actividades',
            'campania_etapas'
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
     * @param  \App\Fase  $fase
     * @return \Illuminate\Http\Response
     */
    public function show(Fase $fase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fase  $fase
     * @return \Illuminate\Http\Response
     */
    public function edit(Fase $fase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fase  $fase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fase $fase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fase  $fase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fase $fase)
    {
        //
    }
}
