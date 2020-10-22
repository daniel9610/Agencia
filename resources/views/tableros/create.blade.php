@extends('layouts.app')
@section('content')
    <tablero-component 
    :actividades="{{ $actividades }}" 
    :campania_etapas="{{ $campania_etapas }}"
    :campania_id="{{ $campania_id }}"
    :estados= "{{$estados}}"
    :users= "{{$users}}"
    ></tablero-component>
@endsection