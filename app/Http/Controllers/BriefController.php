<?php

namespace App\Http\Controllers;

use App\Brief;
use App\Documento;
use App\CampaniaEtapa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\GoogleRepository;
use App\Http\Controllers\GoogleDriveController;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

class BriefController extends Controller
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
        $campania_etapa = CampaniaEtapa::
        where("campania_id", $campania_id)
        ->where("etapa_id", 2)->first();

        // dd($campania_etapa);

        $brief = Brief::where('campania_id', $campania_id)->first();
        $brief->estado_id = $estado_id;
        $brief->save();

        if($estado_id == 9 && $campania_etapa){
            $campania_etapa->estado_id = 1;
            $campania_etapa->save();
        }
        flash('Estado de brief actualizado')->success();
        return back();
    }

    public function subirArchivo(Request $request, $campania_id){
        $carpeta = Documento::where('campania_id', $campania_id)->get();
        $carpeta_padre = $carpeta[0]->drive_id;
        $archivo_drive = $this->google_repository->subirArchivos($request, $this->drive, $carpeta_padre);
        if($archivo_drive){
            return redirect('campanias/'.$campania_id);
        }
    }
}
