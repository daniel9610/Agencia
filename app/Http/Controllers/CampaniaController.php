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
    public function create($cliente_id)
    {
        $campanias = Campania::where('cliente_id', $cliente_id);
        return view ('home', compact('campanias')); 
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
        $campania->porcentaje = 0;
        $campania->cliente_id = $request->cliente_id;
        $campania->fase_id = 1;
        $campania->categoria_id = 1;
        $campania->encargado = $request->encargado;
        $campania->numero_contacto = $request->numero_contacto;
        $campania->email = $request->email;
        $campania->fecha_entrega = $request->fecha_entrega;
        $campania->activo = 1;
        // dd($campania);
        $campania->save();
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campania  $Campania
     * @return \Illuminate\Http\Response
     */
    public function show(Campania $Campania)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Campania  $Campania
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Queda pendiente
        // $campania = Campania::findOrFail($id);
        // return view('', compact('campania'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Campania  $Campania
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campania = Campania::findOrFail($id);
    
        $campania->nombre = $request->nombre;
        $campania->nit = $request->nit;
        $campania->cliente_id = $request->cliente_id;
        $campania->fase_id = 1;
        $campania->categoria_id = 1;
        $campania->encargado = $request->encargado;
        $campania->numero_contacto = $request->numero_contacto;
        $campania->email = $request->email;
        $campania->fecha_entrega = $request->fecha_entrega;
        $campania->activo = 1;
        $category->save();
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Campania  $Campania
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campania = Campania::findOrFail($id);
        $campania->delete();
        return redirect()->route('home');
    }
}
