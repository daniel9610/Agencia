<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $fillable = [
        'nombre', 'tipo', 'campania_id', 'etapa_id', 'drive_id', 'usuario_id'
    ];
}
