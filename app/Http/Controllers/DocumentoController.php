<?php

namespace App\Http\Controllers;

use App\Documento;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    public function crear($nombre, $campania_etapa_id, $drive_id, $usuario_id){
        $documento = new Documento;
        $documento->nombre = $nombre;
        $documento->campania_etapa_id = $campania_etapa_id;
        $documento->drive_id = $drive_id;
        $documento->usuario_id = $usuario_id;
        $documento->save();
        // retornar algo

    }
}
