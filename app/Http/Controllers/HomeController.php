<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campania;
use App\Etapa;
use App\Actividad;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $clientes = array(
            "1" => 'Cliente 1',
            "2" => 'Cliente 2',);
        // $campanias = Campania::all();
        $clientes_id = array(
            1,2
        );
        $etapas = Etapa::all();
        $campanias = Campania::whereBetween('cliente_id', $clientes_id)->get();
        foreach($campanias as $campania){
            $actividades = Actividad::
            join('estados', 'estados.id','actividades.estado_id')
            ->select('estados.porcentaje')
            ->where('actividades.campania_id',$campania->id)
            ->avg('estados.porcentaje');

            if($actividades == null){
                $actvidades = 0;
            }

            $campania->porcentaje = round($actividades);
        }

        return view('home', compact('campanias', 'clientes', 'etapas'));
    
    }
}
