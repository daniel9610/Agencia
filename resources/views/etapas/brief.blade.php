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
@stop