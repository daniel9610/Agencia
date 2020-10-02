<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campania;
use Google_Client;
use Carbon\Carbon;

class CampaniaController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // private $client;
    // private $drive;

    // public function __construct(Google_Client $google)
    // {
    //     $this->client = $google->client();
    //     $this->client->setAccessToken(session('user.token'));
    //     $this->drive = $google->drive($this->client);
    // }


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
    public function create($cliente_id)
    {
        $campanias = Campania::where('cliente_id', $cliente_id);
        return view ('home', compact('campanias')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $campania->save();
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Campania  $Campania
     * @return \Illuminate\Http\Response
     */
    public function show(Campania $Campania)
    {
        //
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

    public function upload()
    {
        return view('etapas.brief');
    }


    // public function doUpload(Request $request)
    // {
    //     if ($request->hasFile('file')) {

    //         $file = $request->file('file');

    //         $mime_type = $file->getMimeType();
    //         $title = $file->getClientOriginalName();
    //         $description = $request->input('description');

    //         $drive_file = new \Google_Service_Drive_DriveFile();
    //         $drive_file->setName($title);
    //         $drive_file->setDescription($description);
    //         $drive_file->setMimeType($mime_type);

    //         try {
    //             $createdFile = $this->drive->files->create($drive_file, [
    //                 'data' => $file,
    //                 'mimeType' => $mime_type,
    //                 'uploadType' => 'multipart'
    //             ]);

    //             $file_id = $createdFile->getId();

    //             return redirect('/upload')
    //                 ->with('message', [
    //                     'type' => 'success',
    //                     'text' => "File was uploaded with the following ID: {$file_id}"
    //             ]);

    //         } catch (Exception $e) {

    //             return redirect('/upload')
    //                 ->with('message', [
    //                     'type' => 'error',
    //                     'text' => 'An error occurred while trying to upload the file'
    //                 ]);

    //         }
    //     }
    // }
}
