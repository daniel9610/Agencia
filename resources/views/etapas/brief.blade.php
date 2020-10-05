@extends('layouts.app')

@section('content')

@foreach ($estados_brief as $estado)
@if($estado_actual == $estado->id)
    <button class="btn btn-primary" disabled>{{$estado->nombre}}</button>->
@else
    <a href="/actualizarestadobrief/{{$campania_id}}/{{$estado->id}}" class="btn btn-primary" >{{$estado->nombre}}</a>->
@endif   

@endforeach

<h3>Cargar documento de brief</h3>
<div class="">
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="POST">
    @csrf
    <div class="row">
        <label for="file">Archivo</label>
        <input type="file" name="file" id="file">
    </div>
    <div class="row">
        <label for="description">Descripción</label>
        <input type="text" name="description" id="description">
    </div>
    <button class="button-primary">Subir</button>
</form>
</div>
<a class="btn btn-primary" href="/campaniaetapas/{{$campania_id}}">Regresar</a>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Nav pills -->
            <ul class="nav nav-pills">
            @foreach ($estados_brief as $estado)
                @if($estado_actual == $estado->id)
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#menu{{$estado->id}}">{{$estado->nombre}}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="pill" href="#menu{{$estado->id}}">{{$estado->nombre}}</a>
                    </li>
                @endif
            @endforeach
            </ul>
            <div class="tab-content">
            @foreach ($estados_brief as $estado)
                @if($estado_actual == $estado->id)
                    <div class="tab-pane container active" id="menu{{$estado->id}}">{{$estado->nombre}}</div>
                @else
                    <div class="tab-pane container fade" id="menu{{$estado->id}}">{{$estado->nombre}}</div>
                @endif
            @endforeach
            </div>
        </div>
        <div class="col-md-12">
            <a class="btn btn-primary mr-auto btn-lg btn-block" href="/campaniaetapas/{{$campania_id}}"><i class="fas fa-arrow-left"></i> Atrás</a>
        </div>
    </div>
</div>
@stop