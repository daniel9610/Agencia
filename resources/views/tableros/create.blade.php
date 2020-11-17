@extends('layouts.app')
@section('content')
    <tablero-component 
    :actividades="{{ $actividades }}" 
    :campania_etapas="{{ $campania_etapas }}"
    :campania_id="{{ $campania_id }}"
    :estados= "{{$estados}}"
    :users= "{{$users}}"
    :sin_iniciar = "{{$sin_iniciar}}"
    :en_proceso = "{{$en_proceso}}"
    :en_revision = "{{$en_revision}}"
    :terminado = "{{$terminado}}"
    :en_ajustes = "{{$en_ajustes}}"
    :aprobado = "{{$aprobado}}"
    ></tablero-component>
@endsection