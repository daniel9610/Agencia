@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Gantt</h1>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <indexgantt-component
            :campanias = "{{$campanias}}"
            :etapas = "{{$etapas}}"
            :campania_etapas = "{{$campania_etapas}}"
            :actividades = "{{$actividades}}"
            :entregables = "{{$entregables}}"
            ></indexgantt-component>
        </div>
    </div>
</div>
@endsection
