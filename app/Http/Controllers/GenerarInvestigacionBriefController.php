<?php

namespace App\Http\Controllers;

use App\CampaniaEtapa;
use App\Documento;
use Illuminate\Http\Request;
use Google_Client;
use Illuminate\Support\Facades\Auth;
use App\Repositories\GoogleRepository;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

class GenerarInvestigacionBriefController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $drive;
    protected $google_repository;

    public function __construct(Google_Client $client, GoogleRepository $google_repository, Request $request){
        $this->middleware(function($request, $next) use ($client){
            $client->refreshToken(Auth::user()->refresh_token);
            $this->drive = new Google_Service_Drive($client);
            return $next($request);
        });
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

    public function subirPresentacion(Request $request, $campania_id){
        $carpeta = Documento::where('campania_id', $campania_id)->get();
        $carpeta_padre = $carpeta[0]->drive_id;
        $archivo_drive = $this->google_repository->subirArchivos($request, $this->drive, $carpeta_padre);
        if($archivo_drive){
            return back()->with("success", "Presentación cargada correctamente");;
        }
    }
}
