<?php

namespace App\Http\Controllers;

use App\CampaniaEtapa;
use App\Etapa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaniaEtapaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCampaniaEtapas($campania_id)
    {

        $campania_etapas = CampaniaEtapa::
            join('etapas', 'campania_etapas.etapa_id', '=', 'etapas.id')
            ->join('estados', 'campania_etapas.estado_id', '=', 'estados.id')
            ->select(
                'etapas.id',
                'campania_etapas.etapa_id',
                'campania_etapas.estado_id',
                'etapas.nombre',
                'etapas.prioridad',
                'etapas.url',
                'estados.nombre as estado'
            )
            ->where('campania_etapas.campania_id', $campania_id)
            ->get();

        if(count($campania_etapas)==0){
            $campania_etapas = "vacio";
        }

        $etapas = Etapa::all();
        $acum = 0;
        $acum2 = 0;
        foreach($etapas as $etapa){
            
            if($campania_etapas != "vacio"){
                foreach($campania_etapas as $campania_etapa){
                    if($etapa->id == $campania_etapa->etapa_id){
                        $etapa->url = $campania_etapa->url;
                        $acum++;
                    }
                }

                if($acum == 0){
                    $etapa->active = false;
                } else {
                    $etapa->active = true;
                }

                foreach($campania_etapas as $campania_etapa){
                    if($etapa->id == $campania_etapa->etapa_id){
                        if($campania_etapa->estado_id == 1 || $campania_etapa->estado_id == 2){
                            $acum2++;
                        }
                    }
                }

                if($acum2 == 0){
                    $etapa->gestion = false;
                } else {
                    $etapa->gestion = true;
                }
    
                $acum = 0;
                $acum2 = 0;
            }
        }

        return view ('etapas.index', compact(['campania_etapas', 'etapas','campania_id']));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agregarCampaniaEtapa($campania_id, $etapa_id, $estado_id)
    {
        $campania_etapa = new CampaniaEtapa;
        $campania_etapa->campania_id = $campania_id;
        $campania_etapa->etapa_id = $etapa_id;
        $campania_etapa->estado_id = 0;
        // Buscar la manera de saber el estado de la etapa anterior
        // if($etapa_id){

        // }
        $campania_etapa->activo = 1;
        $campania_etapa->save();
        $url = '/campaniaetapas/'.$campania_id;
        return redirect($url);
    }

    public function eliminarCampaniaEtapa($campania_id, $etapa_id)
    {
        $campania_etapa = CampaniaEtapa::where('campania_id',$campania_id)->where('etapa_id',$etapa_id);
        $campania_etapa->delete();
        $url = '/campaniaetapas/'.$campania_id;
        return redirect($url);
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
     * @param  \App\CampaniaEtapa  $campaniaEtapa
     * @return \Illuminate\Http\Response
     */
    public function show(CampaniaEtapa $campaniaEtapa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CampaniaEtapa  $campaniaEtapa
     * @return \Illuminate\Http\Response
     */
    public function edit(CampaniaEtapa $campaniaEtapa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CampaniaEtapa  $campaniaEtapa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CampaniaEtapa $campaniaEtapa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CampaniaEtapa  $campaniaEtapa
     * @return \Illuminate\Http\Response
     */
    public function destroy(CampaniaEtapa $campaniaEtapa)
    {
        //
    }
}
