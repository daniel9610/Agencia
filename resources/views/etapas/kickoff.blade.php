@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Kickoff</h1>
    <div class="row">
        @if(session('error') || session('success'))
        <div class="col-md-12">
          <div class="form-panel">
            <div class="row">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @include('alertas.index')
              </div>
            </div>
          </div>
        </div>
        @endif
        <div class="col-md-8">
            <iframe src="https://calendar.google.com/calendar/embed?src=c_cjj12kru97qaa1pfh5ibvcblg8%40group.calendar.google.com&ctz=America%2FBogota" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
        </div>
        <div class="col-md-4">
            <form action="{{ route('crear_reunion') }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="POST">
                @csrf
                <label for="nombre_reunion">Nombre Reunion:</label><br>
                <input type="text" name="nombre_reunion" id="nombre_reunion" required class="form-control"><br>

                <label for="descripcion">Descripción:</label><br>
                <input type="text" name="descripcion" id="descripcion" required class="form-control"><br>

                <label for="fecha_reunion">Fecha Reunion:</label><br>
                <input type="date" name="fecha_reunion" id="fecha_reunion" required class="form-control"><br><br>

                <label for="hora_reunion">Hora Reunion:</label><br>
                <input type="time" name="hora_reunion" id="hora_reunion" required class="form-control"><br><br>
                
                <input type="hidden" name="campania_id" value="{{$campania_id}}">
                <button  type="submit" class="btn btn-primary btn-lg btn-block">Crear Reunion</button>
        </div>
    </div>
    <a class="btn btn-primary mr-auto btn-lg btn-block" href="/campaniaetapas/{{$campania_id}}"><i class="fas fa-arrow-left"></i> Atrás</a>
</div>
@endsection
