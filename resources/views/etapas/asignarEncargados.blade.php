@extends('layouts.app')
@section('content')
<div class="container">
@if (Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ Session::get('success') }}</li>
        </ul>
    </div>
@endif

    <form action="{{ route('asignarencargado') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="POST">
        @csrf
        <label for="cliente">Usuario:</label><br>
        <select name="encargado_id" id="encargado_id" class="form-control" required>
            <option value=""></option>
            @foreach($usuarios as $user)
                <option value="{{ $user->id }}"> {{ $user->name }} </option>
            @endforeach
        </select>

        <label for="campania_etapa_id">Etapa:</label><br>
        <select name="campania_etapa_id" id="campania_etapa_id" required class="form-control">
            <option value=""></option>
            @foreach($etapas as $etapa)
            <option value="{{ $etapa->id }}"> {{ $etapa->nombre }} </option>
        @endforeach
        </select><br>

   <button  type="submit" class="btn btn-primary btn-lg btn-block">Asignar Responsable</button>
    </form>
    <br><br><a class="btn btn-primary mr-auto btn-lg btn-block" href="/campaniaetapas/{{$campania_id}}"><i class="fas fa-arrow-left"></i> Atrás</a>
</div>
@endsection