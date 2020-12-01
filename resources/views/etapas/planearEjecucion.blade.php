@extends('layouts.app')
@section('content')

<div class="container">
    <h1>Planear Ejecución</h1>

@can('campanias.create')
<div class="row justify-content-center">
    {{-- @can('campanias.create') --}}
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
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="accordion" id="accordionExample">

                        <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                Crear Actividad
                                <button class="btn" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                                    </svg>
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                @include('actividades.create')
                            </div>
                        </div>
                        </div>
                        <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                Asignar Actividades
                                <button class="btn" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                                    </svg>
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                                @include('actividades.asignacion')
                            </div>
                        </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h5 class="mb-0">
                                    Respuesta del cliente
                                    <button class="btn" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                                        </svg>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                <div class="card-body">
                                    <form  action="{{ route('clienteAcepta') }}" method="POST" enctype="multipart/form-data" id="formulario">
                                    <input type="hidden" name="_method" value="POST">
                                    @csrf
                                    <input type="hidden" name="campania_id" id="campania_id" value="{{$campania_id}}">
                                    <div style="text-align: center">
                                        <p>¿El cliente aceptó?</p>

                                        <select name="acepta" id="acepta" class="cliente_acepta">
                                            <option value=""></option>
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select><br>

                                        {{-- <input class="cliente_acepta" type="radio" id="si" name="acepta" value="1" required>
                                        <label for="si">Si</label><br>
                                        
                                        <input class="cliente_acepta" type="radio" id="no" name="acepta" value="0">
                                        <label for="no">No</label><br><br> --}}
                                    </div>

                                                                             <!-- Modal -->
                                                                             <div class="modal fade" id="ajustes" tabindex="-1" role="dialog" aria-labelledby="ajustesLabel" aria-hidden="true">
                                                                                <div class="modal-dialog" role="document">
                                                                                  <div class="modal-content">
                                                                                    <div class="modal-header header-title">
                                                                                    <h5 class="modal-title" id="ajustesLabel"><i class="fa fa-trash-alt"></i>Realizar ajustes</h5>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                          
                                                                                              {{-- <div style="text-align: center"> --}}
                                                                                                <label for="desc">Razones</label><br>
                                                                                               <input type="text" name="desc" id="desc" required class="form-control"><br>
                                                                                            {{-- </div> --}}
                                                                                            <input class="btn btn-primary btn-lg btn-block" type="button" id="finalizar-dialog" value="Finalizar">
                                                        
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-danger" id="cerrar-modal" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                                                                                        {{-- <button type="button" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('destroy-form').submit();"><i class="fas fa-check"></i> Eliminar</button> --}}
                                                                                    </div>
                                                                                  </div>
                                                                                </div>
                                                                              </div>

                                         <button class="btn btn-primary btn-lg btn-block" id="finalizar1" type="button" value="Finalizar">Finalizar</button>

                                    </form>
                                    {{-- <a href="{{ URL::route('finalizarCreatividad', $campania_id) }}" class="btn btn-primary btn-lg btn-block">Finalizar Creatividad</a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <h5 style="text-align: center">Plan de ejecución</h5>
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                    Entregables para el cliente
                                    <button class="btn" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                                        </svg>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    @include('entregables.createForClient')
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingFive">
                                <h5 class="mb-0">
                                    Actividades para el cliente
                                    <button class="btn" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                                        </svg>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <div class="card-body">
                                    @include('actividades.createForClient')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
@endcan

<div class="col-md-8">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title clients-header">
             <h5 class="mb-0">
                Actividades
                <button class="btn" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="collapseThree">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                    </svg>
                </button>
            </h5>
            </h5>
            <div class="collapse multi-collapse" id="multiCollapseExample1">
            </div>
            <div class="collapse multi-collapse" id="multiCollapseExample2"> 
                    @include('actividades.index') 
            </div>

            <h5 class="card-title files-header">
            
                {{-- <a href="#" class="card-link btn btn-primary buttons-card-header">Fase de ejecución</a>  --}}
            {{-- <a id="fase_ejecucion" class="btn btn-primary buttons-card-header" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Fase de ejecución</a> --}}
            {{-- <a id="fase_propuesta" class=" buttons-card-header" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Fase diseño de propuesta</a> --}}
            <h5 class="mb-0">
                Archivos
                <button class="btn" type="button" data-toggle="collapse" data-target="#multiCollapseExample3" aria-expanded="false" aria-controls="collapseFour">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                    </svg>
                </button>
            </h5>
                <!-- <a href="#" class="card-link btn btn-primary buttons-card-header">Fase diseño de propuesta</a> -->
            </h5>
            <div class="collapse multi-collapse" id="multiCollapseExample2">

            </div>

            <div class="collapse multi-collapse" id="multiCollapseExample3">  
            <div class="links">
                @if($list == "Sin archivos")
                    Etapa sin presentaciones cargadas
                @else
                @foreach($list as $file)
                    <a target="_blank" href="https://drive.google.com/open?id={{ $file->getId() }}" class="btn btn-primary"><i class="fad fa-file-alt"></i> {{ $file->getName() }}</a>
                @endforeach
                @endif
            </div><br><br>
            </div>


            <h5 class="card-title kickOff-header">
            
                {{-- <a href="#" class="card-link btn btn-primary buttons-card-header">Fase de ejecución</a>  --}}
            {{-- <a id="fase_ejecucion" class="btn btn-primary buttons-card-header" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Fase de ejecución</a> --}}
            {{-- <a id="fase_propuesta" class=" buttons-card-header" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Fase diseño de propuesta</a> --}}
            <h5 class="mb-0">
                Calendario
                <button class="btn" type="button" data-toggle="collapse" data-target="#multiCollapseExample4" aria-expanded="false" aria-controls="collapseFive">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                    </svg>
                </button>
            </h5>
                <!-- <a href="#" class="card-link btn btn-primary buttons-card-header">Fase diseño de propuesta</a> -->
            </h5>
            <div class="collapse multi-collapse" id="multiCollapseExample2">

            </div>

            <div class="collapse multi-collapse" id="multiCollapseExample4">  
                <div class="container">
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
                                <button  type="submit" class="btn btn-primary btn-lg btn-block">Crear Reunion</button><br><br>
                                
                        </div>
                    </div>
                </div>
            </div>

    </div>
</div>





</div>
<br><br><a class="btn btn-primary btn-lg " href="/campaniaetapas/{{$campania_id}}"><i class="fas fa-arrow-left"></i> Atrás</a>




@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
    $(document).ready(function(){

        $( '#finalizar1' ).click(function() {
            var cliente_acepta = $('.cliente_acepta').val();
            if(cliente_acepta == 0)
            {
                $("#ajustes").modal("show");
            }else{
                $("#formulario").submit() 
            }
        });

        $("#finalizar-dialog").click(function(){  
            if($("#desc").val()!=''){
                $("#formulario").submit(); // Submit the form
            }else{
                alert("Debes escribir al menos una razón");
            }   
        });
    });
    </script>

@endpush
    

@endsection
