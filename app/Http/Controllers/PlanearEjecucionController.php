<?php

namespace App\Http\Controllers;

use App\CampaniaEtapa;
use App\Ajuste;
use App\Campania;
use Illuminate\Http\Request;
use Google_Client;
use Illuminate\Support\Facades\Auth;
use App\Repositories\GoogleRepository;

class PlanearEjecucionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $google_repository;

    public function __construct(GoogleRepository $google_repository){
        $this->google_repository = $google_repository;
    }

    public function finalizarPlanearEjecucion($campania_id){
        $campania_etapa = CampaniaEtapa::
        where("campania_id", $campania_id)
        ->where("etapa_id", 6)
        ->first();

        $campania_etapa->estado_id = 2;
        $campania_etapa->save();

        return back()->with("success", "Etapa Planear Ejecucion finalizada");
    }

    public function clienteAcepta(Request $request){
        $campania_id = $request->campania_id;
        $cliente_acepta = $request->acepta;
        $campania = Campania::where('id', $campania_id)->first();
        if($cliente_acepta == 1){
            $campania->fase_id = 2;
            $campania->save();
            return back()->with("success", "Etapa finalizada. La campaña ahora se encuentra en etapa de ejecución");
        }else{
            $campania_etapa = CampaniaEtapa::
            where('campania_id', $campania_id)
            ->where('etapa_id', 6)
            ->first();
            $ajustes = new Ajuste;
            // dd($request->desc);

            $ajustes->campania_etapa_id = $campania_etapa->id;
            $ajustes->descripcion = $request->desc;
            $ajustes->save();
            return back()->with("success", "Ajustes guardados correctamente");
        }
    }
}
