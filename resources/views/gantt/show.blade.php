@extends('layouts.app')
@section('content')
<div class="container">
    <h1>{{$campania[0]->nombre}}</h1>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <showgantt-component
            :campania = "{{$campania}}"
            :entregables = "{{$entregables}}"
            :etapas = "{{$etapas}}"
            :campania_etapas = "{{$campania_etapas}}"
            :actividades = "{{$actividades}}"
            ></showgantt-component>
        </div>
    </div>
</div>
@endsection