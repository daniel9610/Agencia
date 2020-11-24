@extends('layouts.app')
@section('content')
@push('styles')
    <style>
        .isDisabled{
            color: currentColor;
            cursor: not-allowed;
            opacity: 0.5;
            text-decoration: none;
            /* pointer-events: none; */
        }
    </style>
@endpush

<div class="container">
    <h1>Generar Brief</h1>
    <div class="row justify-content-center">

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

        <div class="col-md-12">
            <!-- Nav pills -->
            <ul class="nav nav-pills">
            @foreach ($estados_brief as $estado)
                @if($estado_actual == $estado->id)
                    <li class="nav-item">
                        <a class="nav-link link_estado active" data-toggle="pill" id="{{$estado->id}}" href="#menu{{$estado->id}}">{{$estado->nombre}}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link link_estado isDisabled" data-toggle="pill" id="{{$estado->id}}" href="#menu{{$estado->id}}">{{$estado->nombre}}</a>
                    </li>
                @endif
                <input class="estado" type="hidden" name="estado" id="estado{{$estado->id}}" value="{{$estado->id}}">
            @endforeach
            </ul>
            <div class="tab-content">
            @foreach ($estados_brief as $estado)
                @if($estado->id == 7)
                    <div class="tab-pane container active" id="menu{{$estado->id}}">
                        <h3>Cargar documento de brief</h3>
                        <div class="">
                            {{-- retornar carpeta padre desde controlador --}}
                            <form method="POST" action="{{ route('subirArchivo', $campania_id) }}" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="file">Archivo</label>
                                        <input type="file" name="file" id="file" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <label for="description">Descripción</label>
                                        <input type="text" name="description" id="description" class="form-control">
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-lg btn-block">Subir</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <h5 class="card-title files-header">
            
                        {{-- <a href="#" class="card-link btn btn-primary buttons-card-header">Fase de ejecución</a>  --}}
                    {{-- <a id="fase_ejecucion" class="btn btn-primary buttons-card-header" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Fase de ejecución</a> --}}
                    {{-- <a id="fase_propuesta" class=" buttons-card-header" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Fase diseño de propuesta</a> --}}
                    <h5 class="mb-0">
                        Archivos cargados
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
                            <a target="_blank" href="https://drive.google.com/open?id={{ $file->getId() }}" class="btn btn-primary"><i class="fad fa-file-alt"></i> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-folder" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.828 4a3 3 0 0 1-2.12-.879l-.83-.828A1 1 0 0 0 6.173 2H2.5a1 1 0 0 0-1 .981L1.546 4h-1L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3v1z"/>
                                <path fill-rule="evenodd" d="M13.81 4H2.19a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4zM2.19 3A2 2 0 0 0 .198 5.181l.637 7A2 2 0 0 0 2.826 14h10.348a2 2 0 0 0 1.991-1.819l.637-7A2 2 0 0 0 13.81 3H2.19z"/>
                              </svg> {{ $file->getName() }}</a>
                        @endforeach
                        @endif
                    </div><br><br>
                    </div>
                @else
                    <div class="tab-pane container fade" id="menu{{$estado->id}}">{{$estado->nombre}}</div>
                @endif
            @endforeach
            </div>
        </div>
        <div class="col-md-12">
        </div>
    </div>
    <br><br><a class="btn btn-primary mr-auto btn-lg btn-block" href="/campaniaetapas/{{$campania_id}}"><i class="fas fa-arrow-left"></i> Atrás</a>

</div>
<input class="campania" type="hidden" name="campania" id="campania" value="{{$campania_id}}">
@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("a.link_estado").click(function(){
                var estado = $(this).attr('id');
                var campania = $('#campania').val();
                $.ajax({
                url: '/actualizarestadobrief/'+campania+'/'+estado,
                type: 'GET',
                success: function(response)
                {
                    alert('Estado Actualizado');
                }
                });
            })
        });
    </script>
@endpush
@stop