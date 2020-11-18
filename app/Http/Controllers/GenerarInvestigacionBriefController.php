<?php

namespace App\Http\Controllers;

use App\CampaniaEtapa;
use Illuminate\Http\Request;
use Google_Client;
use Illuminate\Support\Facades\Auth;
use App\Repositories\GoogleRepository;

class GenerarInvestigacionBriefController extends Controller
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

    public function finalizarInvestigacionBrief($campania_id){
        $campania_etapa = CampaniaEtapa::
        where("campania_id", $campania_id)
        ->where("etapa_id", 3)
        ->first();

        $generar_alin_estrategia = CampaniaEtapa::
        where("campania_id", $campania_id)
        ->where("etapa_id", 4)
        ->first();

        $campania_etapa->estado_id = 2;
        $campania_etapa->save();

        if($generar_alin_estrategia){
            $generar_alin_estrategia->estado_id = 1;
            $generar_alin_estrategia->save();        
        }
        return back()->with("success", "Investigación de brief finalizada");
    }
}
