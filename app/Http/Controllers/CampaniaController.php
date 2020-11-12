<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campania;
use App\Categoria;
use Carbon\Carbon;
use App\Estado;
use App\Actividad;
use App\Brief;
use App\Documento;
use App\User;
use App\Http\Controllers\GoogleDriveController;
use Illuminate\Support\Facades\Auth;
use App\Google;

class CampaniaController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        $carpeta_drive = new GoogleDriveController;
        $campania = new Campania;
        $campania->nombre = $request->nombre;
        $campania->nit = $request->nit;
        $campania->porcentaje = 0;
        $campania->cliente_id = $request->cliente_id;
        $campania->fase_id = 1;
        $campania->categoria_id = 1;
        $campania->encargado = $request->encargado;
        $campania->numero_contacto = $request->numero_contacto;
        $campania->email = $request->email;
        $campania->fecha_entrega = $request->fecha_entrega;
        $campania->activo = 1;
        // dd($campania);
        // $campania->save();
        $carpeta_drive->subirFoldersDrive($request);

        // $crear_carpeta_drive->subirFoldersDrive($campania->nombre);


        return redirect()->route('subir_folder', compact('campaniaNombre'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campania  $Campania
     * @return \Illuminate\Http\Response
     */
    public function show($campania_id)
    {
        $google = new Google;
        $result = $google->listarCampaniaFolder($cliente_id);
        dd($result);
        $drive_folder = Documento::where('campania_id', $campania_id)->get();
        $drive_id = $drive_folder[0]->drive_id;
        // dd($drive_id);

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
        $campania->fase_id = 1;
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

        return view ('etapas.brief', compact('estados_brief', 'campania_id','estado_actual'));
    }

    public function vistaKickoff($campania_id){
        return view('etapas.kickoff', compact('campania_id'));
    }

    // Estas funciones se pueden convertir en una sola, definir si es necesario que vayan separadas
    public function vistaGenerarInvestigacionBrief($campania_id, $etapa_id){
        $estados_actividades = Estado::where('tipo_estado', 3)->get();
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
        return view('etapas.generarInvestigacionBrief', compact('campania_id', 'estados_actividades', 'etapa_id', 'actividades', 'users', 'actividades_a_asignar'));
    } 

    public function vistaGenerarAlinearEstrategia($campania_id, $etapa_id){
        $estados_actividades = Estado::where('tipo_estado', 3)->get();
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
        return view('etapas.generarAlinearEstrategia', compact('campania_id', 'estados_actividades', 'etapa_id', 'actividades', 'users', 'actividades_a_asignar'));
    } 

    public function vistaGenerarCreatividad($campania_id, $etapa_id){
        $estados_actividades = Estado::where('tipo_estado', 3)->get();
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
        return view('etapas.generarCreatividad', compact('campania_id', 'estados_actividades', 'etapa_id', 'actividades', 'users', 'actividades_a_asignar'));
    } 

    public function vistaPlanearEjecucion($campania_id, $etapa_id){
        $estados_actividades = Estado::where('tipo_estado', 3)->get();
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
        return view('etapas.planearEjecucion', compact('campania_id', 'estados_actividades', 'etapa_id', 'actividades', 'users', 'actividades_a_asignar'));
    } 


    
}
