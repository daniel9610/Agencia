<?php

namespace App\Http\Controllers;

use App\CampaniaEtapa;
use Illuminate\Http\Request;
use Google_Client;
use Illuminate\Support\Facades\Auth;
use App\Repositories\GoogleRepository;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

class GenerarAlinearEstrategiaController extends Controller
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

    public function finalizarAlinearEstrategia($campania_id){
        $campania_etapa = CampaniaEtapa::
        where("campania_id", $campania_id)
        ->where("etapa_id", 4)
        ->first();

        $generar_creatividad = CampaniaEtapa::
        where("campania_id", $campania_id)
        ->where("etapa_id", 5)
        ->first();

        $campania_etapa->estado_id = 2;
        $campania_etapa->save();

        if($generar_creatividad){
            $generar_creatividad->estado_id = 1;
            $generar_creatividad->save();        
        }
        return back()->with("success", "Alineación de estrategia finalizada");
    }
}
