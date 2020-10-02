@extends('layouts.app')

@section('content')
<h3>Cargar documento de brief</h3>
<div>
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
@stop