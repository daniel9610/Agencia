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

          <div class="accordion" id="accordionExample">

          <div class="card">
            <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    Crear Eventos
                    <button class="btn" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                        </svg>
                    </button>
                </h5>
            </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
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
                    <button  type="submit" class="btn btn-primary btn-lg btn-block">Crear Reunion</button><br><br>    
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header" id="headingFour">
                  <h5 class="mb-0">
                      Definir Entregables
                      <button class="btn" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                          </svg>
                      </button>
                  </h5>
              </div>
              <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                  <div class="card-body">
                      @include('entregables.create')
                  </div>
              </div>
            </div>

          </div>
          <br>
          <a href="{{ URL::route('creartablero', $campania_id) }}" class="btn btn-primary btn-lg btn-block" target="_blank">Crear Actividades</a>
          <a href="{{ URL::route('finalizarkickoff', $campania_id) }}" class="btn btn-primary btn-lg btn-block">Finalizar KickOff</a>
        </div>
      </div>
    <a class="btn btn-primary mr-auto btn-lg btn-block" href="/campaniaetapas/{{$campania_id}}"><i class="fas fa-arrow-left"></i> Atrás</a>
</div>
@endsection
