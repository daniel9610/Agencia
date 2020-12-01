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

    <form action="{{ route('asignar_rol') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="POST">
        @csrf
        <label for="cliente">Usuario:</label><br>
        <select name="user_id" id="user_id" class="form-control" required>
            <option value=""></option>
            @foreach($users as $user)
                <option value="{{ $user->id }}"> {{ $user->name }} </option>
            @endforeach
        </select>

        <label for="nombre_rol">Rol:</label><br>
        <select name="nombre_rol" id="nombre_rol" required class="form-control">
            <option value=""></option>
            @foreach($roles as $rol)
            <option value="{{ $rol->id }}"> {{ $rol->name }} </option>
        @endforeach
        </select><br>

        <label for="nombre_rol">Cargo:</label><br>
        <select name="cargo_id" id="cargo_id" required class="form-control">
            <option value=""></option>
            @foreach($cargos as $cargo)
            <option value="{{ $cargo->id }}"> {{ $cargo->nombre }} </option>
        @endforeach
        </select><br>

   <button  type="submit" class="btn btn-primary btn-lg btn-block">Asignar rol</button>
    </form>
</div>
@endsection