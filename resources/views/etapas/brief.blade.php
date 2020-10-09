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
{{--@foreach ($estados_brief as $estado)
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
<a class="btn btn-primary" href="/campaniaetapas/{{$campania_id}}">Regresar</a> --}}
<div class="container">
    <h1>Generar Brief</h1>
    <div class="row justify-content-center">
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
                        {{$estado->nombre}}
                        <h3>Cargar documento de brief</h3>
                        <div class="">
                            <form method="POST" enctype="multipart/form-data">
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