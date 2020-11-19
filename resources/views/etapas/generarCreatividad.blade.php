@extends('layouts.app')
@section('content')

<div class="container">
    <h1>Generar Creatividad</h1>

<div class="row justify-content-center">
    {{-- @can('campanias.create') --}}
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
                            <div class="card-header" id="headingFive">
                                <h5 class="mb-0">
                                    Subir Presentación
                                    <button class="btn" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                                        </svg>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                                <div class="card-body">
                                    <div style="text-align: center">
                                    <h3>Cargar Presentación</h3>
                                        {{-- retornar carpeta padre desde controlador --}}
                                        <form method="POST" action="{{ route('subirPresentacion', $campania_id) }}" enctype="multipart/form-data">
                                            <input type="hidden" name="_method" value="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="file">Archivo</label>
                                                    <input type="file" name="file" id="file" class="form-control">
                                                </div>
                                                <div class="col-12">
                                                    <br><label for="description">Descripción</label>
                                                    <input type="text" name="description" id="description" class="form-control">
                                                </div>
                                                <div class="col-12">
                                                    <br><button class="btn btn-primary btn-lg btn-block">Subir</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingFour">
                                <h5 class="mb-0">
                                    Marcar como finalizado
                                    <button class="btn" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                                        </svg>
                                    </button>
                                </h5>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                                <div class="card-body">
                                    <a href="{{ URL::route('finalizarCreatividad', $campania_id) }}" class="btn btn-primary btn-lg btn-block">Finalizar Creatividad</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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
            <div class="collapse multi-collapse show" id="multiCollapseExample2"> 
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

            <div class="collapse multi-collapse show" id="multiCollapseExample3">  
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

    </div>
</div>





</div>
<br><br><a class="btn btn-primary btn-lg " href="/campaniaetapas/{{$campania_id}}"><i class="fas fa-arrow-left"></i> Atrás</a>

    

@endsection
