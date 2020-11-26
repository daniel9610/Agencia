<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campania;
use App\Etapa;
use App\Cliente;
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
               
        $clientes = Cliente::where('activo', 1)->get();
        // $clientes_fase_ejecucion = Cliente::where('fase_id', 2)->get();
       
        // dd(count($clientes_fase_ejecucion));
        $etapas = Etapa::all();
        $campanias_fase_diseño = Campania::where('fase_id', 1)->get();
        $campanias_fase_ejecucion = Campania::where('fase_id', 2)->get();

        if(count($campanias_fase_diseño)>0){
            foreach($campanias_fase_diseño as $campania){
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
        }

        if(count($campanias_fase_ejecucion)>0){
            foreach($campanias_fase_ejecucion as $campania){
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
        }
        

        return view('home', compact('etapas', 'clientes', 'campanias_fase_diseño', 'campanias_fase_ejecucion'));
    
    }
}
