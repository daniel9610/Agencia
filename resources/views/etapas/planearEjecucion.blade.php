@extends('layouts.app')
@section('content')

<div class="container">
    <h1>Planear Ejecución</h1>

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

    </div>
</div>





</div>
<br><br><a class="btn btn-primary btn-lg " href="/campaniaetapas/{{$campania_id}}"><i class="fas fa-arrow-left"></i> Atrás</a>

    

@endsection
