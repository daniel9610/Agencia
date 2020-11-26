<?php

namespace App\Http\Controllers;

use App\Kickoff;
use App\CampaniaEtapa;
use Illuminate\Http\Request;
use Google_Service_Calendar;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Calendar_Event;
use Google_Client;
use Illuminate\Support\Facades\Auth;
use App\Repositories\GoogleRepository;

class KickoffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $google_repository;

    public function __construct(Google_Client $client, GoogleRepository $google_repository, Request $request){
        $this->middleware(function($request, $next) use ($client){
            $client->refreshToken(Auth::user()->refresh_token);
            $this->client = $client;
            // $this->calendar = new Google_Service_Calendar($client);
            return $next($request);
        });
        $this->google_repository = $google_repository;
    }

    public function programarKickOff(Request $request){
        $campania_id = $request->campania_id;
        $id_calendar=$request->calendar_id;
        // $id_calendar=env('CALENDARIO_ID');

        // dd($id_calendar);

        $dateTimeReunion = $request->fecha_reunion . $request->hora_reunion;
        $nombre=$request->nombre_reunion;
        $descripcion = $request->descripcion;
        $crear_evento = $this->google_repository->crearEventosCalendar($campania_id,$id_calendar, $dateTimeReunion, $nombre, $descripcion, $this->client);
        // dd($crear_evento);
        return $crear_evento;
    }

    public function finalizarKickOff($campania_id){
        $campania_etapa = CampaniaEtapa::
        where("campania_id", $campania_id)
        ->where("etapa_id", 2)
        ->first();

        $generar_inv_brief = CampaniaEtapa::
        where("campania_id", $campania_id)
        ->where("etapa_id", 3)
        ->first();

        $campania_etapa->estado_id = 2;
        $campania_etapa->save();

        if($generar_inv_brief){
            $generar_inv_brief->estado_id = 1;
            $generar_inv_brief->save();
        }
        return back()->with("success", "kickOff finalizado");
    }
}
