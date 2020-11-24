<?php

namespace App\Http\Controllers;

use App\Actividad;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GoogleDriveController;
use Google_Client;
use App\Repositories\EmailRepository;

class ActividadController extends Controller
{
    protected $emailrepository;

    public function __construct(EmailRepository $emailrepository){
        $this->emailrepository = $emailrepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->campania_id);
        $actividad = new Actividad;
        $actividad->nombre = $request->nombre;
        $actividad->prioridad = $request->prioridad;
        $actividad->campania_id = $request->campania_id;
        $actividad->etapa_id = $request->etapa_id;
        // $actividad->gant_id = $request->gant_id;
        $actividad->estado_id = $request->estado_id;
        $actividad->fecha_entrega = $request->fecha_entrega;
        $actividad->save();
        $m = "Actividad ".$actividad->nombre." creada correctamente";
        return back()->with('status',$m);
    }

    public function storeActividad(Request $request)
    {
        // dd($request->campania_id);
        $actividad = new Actividad;
        $actividad->nombre = $request->nombre;
        $actividad->descripcion = $request->descripcion;
        $actividad->prioridad = $request->prioridad;
        $actividad->campania_id = $request->campania_id;
        $actividad->etapa_id = $request->etapa_id;
        $actividad->autor_id = Auth::user()->id;
        $actividad->usuario_asignado = $request->usuario_asignado;
        // $actividad->gant_id = $request->gant_id;
        $actividad->estado_id = $request->estado_id;
        $actividad->fecha_entrega = $request->fecha_entrega;
        $actividad->fecha_asignacion = Carbon::now();
        $actividad->save();
        return response()->json('Actividad Guardada',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function show(Actividad $actividad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function edit(Actividad $actividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */

    // Asignación de actividades
    public function update(Request $request, $id)
    {
        // $calendar = new GoogleDriveController();
        // $calendar->crearEventosCalendar();
        $fecha = Carbon::now();
        $actividad = Actividad::findOrFail($request->actividad_id);
        $actividad->autor_id = Auth::user()->id;
        $actividad->usuario_asignado = $request->usuario_asignado;
        $actividad->fecha_asignacion = $fecha->toDateTimeString();
        $actividad->save();
        $m = "Actividad ".$actividad->nombre." asignada correctamente"; 
        return back()->with('status',$m);
    }

    public function updateActividad(Request $request, $id)
    {
        $response = Actividad::where('id',$id)
        ->update(array(
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'prioridad' => $request->prioridad,
            'etapa_id' => $request->etapa_id,
            'usuario_asignado' => $request->usuario_asignado,
            'estado_id' => $request->estado_id,
            'fecha_entrega' => $request->fecha_entrega,
        ));
        return response()->json('Actividad Actualizada',200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Actividad  $actividad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actividad $actividad)
    {
        //
    }

    public function test_email(){
        $remitentes = 'ricardo.franco@tars.dev, daniel.jimenez@tars.dev, jeisson.lopez@tars.dev';
        $nombre_correo = 'Prueba correo agencia';
        $asunto = 'Prueba correo agencia';
        $cuerpo = 'Esto es una prueba de correo para la aplicación de agencia';

        $this->emailrepository->sendEmail($remitentes,$nombre_correo,$asunto,$cuerpo);
        return redirect('/home');
    }
}
