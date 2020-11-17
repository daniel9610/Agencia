<?php

namespace App\Http\Controllers;

use App\Kickoff;
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

    public function __construct(GoogleRepository $google_repository){
        $this->google_repository = $google_repository;
    }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kickoff  $kickoff
     * @return \Illuminate\Http\Response
     */
    public function show(Kickoff $kickoff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kickoff  $kickoff
     * @return \Illuminate\Http\Response
     */
    public function edit(Kickoff $kickoff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kickoff  $kickoff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kickoff $kickoff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kickoff  $kickoff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kickoff $kickoff)
    {
        //
    }

    public function programarKickOff(Request $request){
        $campania_id = $request->campania_id;
        // $id_calendar=$request->calendar_id;
        $id_calendar=env('CALENDARIO_ID');

        // dd($id_calendar);

        $dateTimeReunion = $request->fecha_reunion . $request->hora_reunion;
        $nombre=$request->nombre_reunion;
        $descripcion = $request->descripcion;
        $crear_evento = $this->google_repository->crearEventosCalendar($campania_id,$id_calendar, $dateTimeReunion, $nombre, $descripcion);
        // dd($crear_evento);
        return $crear_evento;
    }
}
