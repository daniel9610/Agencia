<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campania;
use App\Categoria;
use App\Entregable;
use App\CampaniaEtapa;
use Carbon\Carbon;
use App\Estado;
use App\Actividad;
use App\Brief;
use App\Documento;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Repositories\GoogleRepository;
use App\Http\Controllers\GoogleDriveController;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

class CampaniaController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $drive;
    // public $calendar;
    protected $google_repository;

    public function __construct(Google_Client $client, GoogleRepository $google_repository, Request $request){
        $this->middleware(function($request, $next) use ($client){
            $client->refreshToken(Auth::user()->refresh_token);
            $this->drive = new Google_Service_Drive($client);
            // $this->calendar = new Google_Service_Calendar($client);
            return $next($request);
        });
        $this->google_repository = $google_repository;
    }

    public function index()
    {

        $campanias = Campania::all();
        return view ('home', compact('campanias'));
    }

    public function indexCampaniaCliente($cliente_id)
    {

        $campanias = Campania::where('cliente_id', $cliente_id);
        return view ('home', compact('campanias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create($cliente_id)
    // {

    //     $campanias = Campania::where('cliente_id', $cliente_id);
    //     return view ('home', compact('campanias'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $carpeta_drive = new Google;

        // $result = (new GoogleDriveController)->subirFoldersDrive($request);

        $campania = new Campania;
        $documento = new Documento;
        $carpeta_nombre = $request->nombre;
        $campania->nombre = $request->nombre;
        $campania->nit = $request->nit;
        $campania->porcentaje = 0;
        $campania->cliente_id = $request->cliente_id;
        $campania->categoria_id = 1;
        $campania->fase_id = 1;
        $campania->encargado = $request->encargado;
        $campania->numero_contacto = $request->numero_contacto;
        $campania->email = $request->email;
        $campania->fecha_entrega = $request->fecha_entrega;
        $campania->activo = 1;
        $carpeta_drive = $this->google_repository->subirFoldersDrive($request, $this->drive);
        $calendario = $this->google_repository->crearCalendario($request);
        $campania->calendar_id = $calendario->getId();
        $campania->save();

        $documento->nombre = $carpeta_nombre;
        $documento->tipo = "carpeta campania";
        $documento->campania_id = $campania->id;
        $documento->usuario_id = Auth::user()->id;
        // dd($carpeta_drive);
        $documento->drive_id = $carpeta_drive->id;
        $documento->save();

        for($i=1; $i<=6; $i++){
            $etapas = new CampaniaEtapa;
            $etapas->campania_id = $campania->id;
            $etapas->etapa_id = $i;
            if($i == 1){
                $etapas->estado_id = 1;
            }else{
                $etapas->estado_id = 0;
            }
            $etapas->activo = 1;
            $etapas->save();
        }

        // $crear_carpeta_drive->subirFoldersDrive($campania->nombre);

        return redirect()->route('home')->with('success','Campaña creada correctamente');

        // return redirect()->route('subir_folder', compact('campaniaNombre'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campania  $Campania
     * @return \Illuminate\Http\Response
     */
    public function show($campania_id)
    {
        $drive_folder = Documento::where('campania_id', $campania_id)->get();
        $drive_id = $drive_folder[0]->drive_id;
        $tipo_archivo = "xlsx";
        $list = $this->google_repository->ListarFolders($drive_id, $this->drive, $tipo_archivo);
        print view('campanias.index', compact('list'));
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

    public function vistaSubirBrief($campania_id)
    {
        $estado_actual = Brief::where('campania_id', $campania_id)->get();
        $estados_brief = Estado::where('tipo_estado', 1)->get();

        $drive_folder = Documento::where('campania_id', $campania_id)->get();
        $drive_id = $drive_folder[0]->drive_id;
        $tipo_archivo = "xlsx";
        $archivos = $this->google_repository->ListarFolders($drive_id, $this->drive, $tipo_archivo);
        if($archivos){
            $list = $archivos;
        }else{
            $list = "Sin archivos";
        }

        if(empty($estado_actual[0])){
            $brief = new Brief;
            $brief->nombre = "brief campania id: $campania_id";
            $brief->campania_id = $campania_id;
            $brief->estado_id = 3;
            // $brief->documento_id = $request->documento_id;
            // $brief->fecha_inicio = $request->fecha_inicio;
            // $brief->fecha_fin = $request->fecha_fin;
            $brief->save();
        }
        $estado_actual = Brief::where('campania_id', $campania_id)->get();
        $estado_actual = $estado_actual[0]->estado_id;

        return view ('etapas.brief', compact('estados_brief', 'campania_id','estado_actual', 'list'));
    }

    public function vistaKickoff($campania_id){
        $etapas = CampaniaEtapa::
        join('etapas', 'campania_etapas.etapa_id', '=', 'etapas.id')
        ->join('estados', 'campania_etapas.estado_id', '=', 'estados.id')
        ->select(
            'campania_etapas.id as id',
            'campania_etapas.etapa_id as etapa_id',
            'campania_etapas.estado_id',
            'etapas.nombre',
            'etapas.prioridad',
            'etapas.url',
            'estados.nombre as estado'
        )
        ->where('campania_etapas.campania_id', $campania_id)
        ->get();

        $campania = Campania::where('id', $campania_id)->first();

        return view('etapas.kickoff', compact('campania_id', 'etapas', 'campania'));
    }

    // Estas funciones se pueden convertir en una sola, definir si es necesario que vayan separadas
    public function vistaGenerarInvestigacionBrief($campania_id, $etapa_id){
        $estados_actividades = Estado::where('tipo_estado', 3)->get();
        $entregables = Entregable::where('campania_id', $campania_id)->where('etapa_id', $etapa_id)->get();
        if(count($entregables)==0){
            $entregables = "No hay entregables";
        }

        $drive_folder = Documento::where('campania_id', $campania_id)->get();
        $drive_id = $drive_folder[0]->drive_id;
        $tipo_archivo = "ppt";
        $archivos = $this->google_repository->ListarFolders($drive_id, $this->drive, $tipo_archivo);
        // dd($archivos);

        if($archivos == "Sin archivos"){
            $list = "Sin archivos";

        }else{
            $list = $archivos;
        }

        if(Auth::user()->getRoleNames()[0] == 'Director' || Auth::user()->getRoleNames()[0] == 'PMO'){

            $actividades = Actividad::
            join('users', 'actividades.usuario_asignado', '=', 'users.id')
            ->join('estados', 'actividades.estado_id', '=', 'estados.id')
            ->select('actividades.id','actividades.nombre','actividades.prioridad', 'estados.nombre as estado_id', 'users.name as usuario_asignado', 'actividades.fecha_entrega')
            ->where('campania_id', $campania_id)->where('etapa_id', $etapa_id)
            ->get();

        }else{

            $actividades = Actividad::
            join('users', 'actividades.usuario_asignado', '=', 'users.id')
            ->join('estados', 'actividades.estado_id', '=', 'estados.id')
            ->select('actividades.id','actividades.nombre','actividades.prioridad', 'estados.nombre as estado_id', 'users.name as usuario_asignado', 'actividades.fecha_entrega')
            ->where('campania_id', $campania_id)->where('etapa_id', $etapa_id)
            ->where('usuario_asignado', Auth::user()->id)
            ->get();

        }


        $actividades_a_asignar = Actividad::where('campania_id', $campania_id)->where('etapa_id', $etapa_id)->where('usuario_asignado', null)->get();

        $users = User::all();
        // $campania_etapa = Campania
        return view('etapas.generarInvestigacionBrief', compact('campania_id', 'estados_actividades', 'etapa_id', 'actividades', 'users', 'actividades_a_asignar', 'list', 'entregables'));
    }

    public function vistaGenerarAlinearEstrategia($campania_id, $etapa_id){
        $estados_actividades = Estado::where('tipo_estado', 3)->get();

        $drive_folder = Documento::where('campania_id', $campania_id)->get();
        $drive_id = $drive_folder[0]->drive_id;
        $tipo_archivo = "ppt";
        $archivos = $this->google_repository->ListarFolders($drive_id, $this->drive, $tipo_archivo);
        if($archivos){
            $list = $archivos;
        }else{
            $list = "Sin archivos";
        }

        if(Auth::user()->getRoleNames()[0] == 'Director' || Auth::user()->getRoleNames()[0] == 'PMO'){
            $actividades = Actividad::
            join('users', 'actividades.usuario_asignado', '=', 'users.id')
            ->join('estados', 'actividades.estado_id', '=', 'estados.id')
            ->select('actividades.id','actividades.nombre','actividades.prioridad', 'estados.nombre as estado_id', 'users.name as usuario_asignado', 'actividades.fecha_entrega')
            ->where('campania_id', $campania_id)->where('etapa_id', $etapa_id)
            ->get();
        }else{
            $actividades = Actividad::
            join('users', 'actividades.usuario_asignado', '=', 'users.id')
            ->join('estados', 'actividades.estado_id', '=', 'estados.id')
            ->select('actividades.id','actividades.nombre','actividades.prioridad', 'estados.nombre as estado_id', 'users.name as usuario_asignado', 'actividades.fecha_entrega')
            ->where('campania_id', $campania_id)->where('etapa_id', $etapa_id)
            ->where('usuario_asignado', Auth::user()->id)
            ->get();
        }
        $actividades_a_asignar = Actividad::where('campania_id', $campania_id)->where('etapa_id', $etapa_id)->where('usuario_asignado', null)->get();
        $users = User::all();
        $entregables = Entregable::where('campania_id', $campania_id)->where('etapa_id', $etapa_id)->get();
        if(count($entregables)==0){
            $entregables = "No hay entregables";
        }
        // $campania_etapa = Campania
        return view('etapas.generarAlinearEstrategia', compact('campania_id', 'estados_actividades', 'etapa_id', 'actividades', 'users', 'actividades_a_asignar', 'list', 'entregables'));
    }

    public function vistaGenerarCreatividad($campania_id, $etapa_id){
        $estados_actividades = Estado::where('tipo_estado', 3)->get();

        $drive_folder = Documento::where('campania_id', $campania_id)->get();
        $drive_id = $drive_folder[0]->drive_id;
        $tipo_archivo = "ppt";
        $archivos = $this->google_repository->ListarFolders($drive_id, $this->drive, $tipo_archivo);
        if($archivos){
            $list = $archivos;
        }else{
            $list = "Sin archivos";
        }

        if(Auth::user()->getRoleNames()[0] == 'Director' || Auth::user()->getRoleNames()[0] == 'PMO'){
            $actividades = Actividad::
            join('users', 'actividades.usuario_asignado', '=', 'users.id')
            ->join('estados', 'actividades.estado_id', '=', 'estados.id')
            ->select('actividades.id','actividades.nombre','actividades.prioridad', 'estados.nombre as estado_id', 'users.name as usuario_asignado', 'actividades.fecha_entrega')
            ->where('campania_id', $campania_id)->where('etapa_id', $etapa_id)
            ->get();
        }else{
            $actividades = Actividad::
            join('users', 'actividades.usuario_asignado', '=', 'users.id')
            ->join('estados', 'actividades.estado_id', '=', 'estados.id')
            ->select('actividades.id','actividades.nombre','actividades.prioridad', 'estados.nombre as estado_id', 'users.name as usuario_asignado', 'actividades.fecha_entrega')
            ->where('campania_id', $campania_id)->where('etapa_id', $etapa_id)
            ->where('usuario_asignado', Auth::user()->id)
            ->get();
        }
        $actividades_a_asignar = Actividad::where('campania_id', $campania_id)->where('etapa_id', $etapa_id)->where('usuario_asignado', null)->get();
        $users = User::all();
        $entregables = Entregable::where('campania_id', $campania_id)->where('etapa_id', $etapa_id)->get();

        // $campania_etapa = Campania
        return view('etapas.generarCreatividad', compact('campania_id', 'estados_actividades', 'etapa_id', 'actividades', 'users', 'actividades_a_asignar', 'list', 'entregables'));
    }

    public function vistaPlanearEjecucion($campania_id, $etapa_id){
        $estados_actividades = Estado::where('tipo_estado', 3)->get();

        $drive_folder = Documento::where('campania_id', $campania_id)->get();
        $drive_id = $drive_folder[0]->drive_id;
        $tipo_archivo = "ppt";
        $archivos = $this->google_repository->ListarFolders($drive_id, $this->drive, $tipo_archivo);
        if($archivos){
            $list = $archivos;
        }else{
            $list = "Sin archivos";
        }

        if(Auth::user()->getRoleNames()[0] == 'Director' || Auth::user()->getRoleNames()[0] == 'PMO'){
            $actividades = Actividad::
            join('users', 'actividades.usuario_asignado', '=', 'users.id')
            ->join('estados', 'actividades.estado_id', '=', 'estados.id')
            ->select('actividades.id','actividades.nombre','actividades.prioridad', 'estados.nombre as estado_id', 'users.name as usuario_asignado', 'actividades.fecha_entrega')
            ->where('campania_id', $campania_id)->where('etapa_id', $etapa_id)
            ->get();
        }else{
            $actividades = Actividad::
            join('users', 'actividades.usuario_asignado', '=', 'users.id')
            ->join('estados', 'actividades.estado_id', '=', 'estados.id')
            ->select('actividades.id','actividades.nombre','actividades.prioridad', 'estados.nombre as estado_id', 'users.name as usuario_asignado', 'actividades.fecha_entrega')
            ->where('campania_id', $campania_id)->where('etapa_id', $etapa_id)
            ->where('usuario_asignado', Auth::user()->id)
            ->get();
        }
        $actividades_a_asignar = Actividad::where('campania_id', $campania_id)->where('etapa_id', $etapa_id)->where('usuario_asignado', null)->get();
        $users = User::all();
        $entregables = Entregable::where('campania_id', $campania_id)->where('etapa_id', $etapa_id)->get();
        if(count($entregables)==0){
            $entregables = "No hay entregables";
        }
        // $campania_etapa = Campania
        return view('etapas.planearEjecucion', compact('campania_id', 'estados_actividades', 'etapa_id', 'actividades', 'users', 'actividades_a_asignar', 'list', 'entregables'));
    }



}
