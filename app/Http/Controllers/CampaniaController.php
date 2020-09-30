<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campania;

class CampaniaController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campanias = Campania::all();
        return view ('home', compact('campanias'));
    }

    public function indexCampaniaCliente($campania_id)
    {
        $campanias = Campania::where('campania_id', $campania_id);
        return view ('home', compact('campanias'));
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
        $campania = new Campania;
        $campania->nombre = $request->nombre;
        $campania->nit = $request->nit;
        $campania->porcentaje = $request->porcentaje;
        $campania->cliente_id = $request->cliente_id;
        $campania->fase_id = $request->fase_id;
        $campania->categoria_id = $request->categoria_id;
        $campania->encargado = $request->encargado;
        $campania->numero_contacto = $request->numero_contacto;
        $campania->email = $request->email;
        $campania->fecha_entrega = $request->fecha_entrega;
        $campania->activo = 1;
        $campania->save();
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
