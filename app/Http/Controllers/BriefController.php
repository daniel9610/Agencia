<?php

namespace App\Http\Controllers;

use App\Brief;
use Illuminate\Http\Request;

class BriefController extends Controller
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
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $brief = new Brief;
        $brief->nombre = $request->nombre;
        $brief->campania_id = $request->campania_id;
        $brief->estado_id = $request->estado_id;
        $brief->documento_id = $request->documento_id;
        $brief->fecha_inicio = $request->fecha_inicio;
        $brief->fecha_fin = $request->fecha_fin;
        $brief->save();

        return redirect('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brief  $brief
     * @return \Illuminate\Http\Response
     */
    public function show(Brief $brief)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brief  $brief
     * @return \Illuminate\Http\Response
     */
    public function edit(Brief $brief)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brief  $brief
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $brief_id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brief  $brief
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brief $brief)
    {
        //
    }

    public function actualizarEstado($campania_id, $estado_id)
    {
        $brief = Brief::where('campania_id', $campania_id)->first();
        // dd($brief);
        $brief->estado_id = $estado_id;
        $brief->save();
        flash('Estado de brief actualizado')->success();
        return back();
    }
}
