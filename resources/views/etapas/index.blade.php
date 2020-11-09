@extends('layouts.app')
@section('content')
@push('styles')
    <style>
        .arrow{
            cursor:pointer;
        }

        .disabled_li{
            pointer-events:none; //This makes it not clickable
            opacity:0.6;
        }
    </style>
@endpush
{{-- <div>
    @if($campania_etapas == "vacio")

        No hay etapas asignadas a esta campaña
        <button class="btn btn-dark">Agregar etapas</button>   
     
    @else
        @foreach ($campania_etapas as $etapa)
        
            <a href="{{URL::current()}}/{{$etapa->url}}" class="btn btn-dark">{{$etapa->nombre}}</a>   
        @endforeach
    @endif 

</div><br><br> --}}

<div class="container">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <h1>Etapas</h1>
    <div class="row justify-content-center">
        @if($campania_etapas != "vacio")
        <div class="col-md-5">
            <h5>Asignadas</h5>
            <ul class="list-group">
                @foreach($etapas as $etapa)
                    @if($etapa->active == true)
                        <li class="list-group-item activa_item arrow" id="activa{{$etapa->id}}" value="{{$etapa->id}}">{{$etapa->nombre}} <a href="{{URL::current()}}/{{$etapa->id}}/{{$etapa->url}}" class="btn btn-dark" style="display: none" id="button{{$etapa->id}}">Gestionar</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    @can('campanias.create')

        <div class="col-md-2">
            <button class="btn btn-primary btn-lg btn-block" id="agregar" disabled>Agregar</button>
            <button class="btn btn-primary btn-lg btn-block" id="quitar" disabled>Quitar</button>
        </div>

        <div class="col-md-5">
            <h5>Disponibles</h5>
            <ul class="list-group">
                @foreach($etapas as $etapa)
                    @if($etapa->active == false)
                        <li class="list-group-item disponible_item arrow" id="disponible{{$etapa->id}}" value="{{$etapa->id}}">{{$etapa->nombre}}</li>
                    @endif
                @endforeach
                {{-- <li class="list-group-item active">Vestibulum at eros</li> --}}
            </ul>
        </div>
    @endcan

        @else
        <div class="col-md-5">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary btn-lg btn-block" id="agregar" disabled>Agregar</button>
            <button class="btn btn-primary btn-lg btn-block" id="quitar" disabled>Quitar</button>
        </div>
        <div class="col-md-5">
            <ul class="list-group">
                @foreach($etapas as $etapa)
                    @if($etapa->active == false)
                        <li class="list-group-item disponible_item arrow" id="disponible{{$etapa->id}}" value="{{$etapa->id}}">{{$etapa->nombre}}</li>
                    @endif
                @endforeach
                {{-- <li class="list-group-item active">Vestibulum at eros</li> --}}
            </ul>
        </div>
        @endif
    
        <div class="col-md-12">
            <br><br><a class="btn btn-primary mr-auto btn-lg btn-block" href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Atrás</a>
        </div>
        <input type="hidden" name="campania_id" id="campania_id" value="{{$campania_id}}">
    </div>
</div>

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        $(document).ready(function(){

            var activa = '';
            var button_activa = '';
            var campania_id = $('#campania_id').val();
            var etapa_id = '';

            $('#agregar').click(function(){
                $.ajax({
                url: '/agregarcampaniaetapa/'+campania_id+'/'+etapa_id+'/1',
                type: 'GET',
                success: function(response)
                {
                    window.location = "/campaniaetapas/"+campania_id;
                }
                });
            });

            $('#quitar').click(function(){
                $.ajax({
                url: '/eliminarcampaniaetapa/'+campania_id+'/'+etapa_id,
                type: 'GET',
                success: function(response)
                {
                    window.location = "/campaniaetapas/"+campania_id;
                }
                });
            });

            $("li.disponible_item").click(function(){
                $(button_activa).css("display", "none");
                var string = $(this).attr('id');
                var id = string.replace(/^disponible+/i,'');
                etapa_id = id;
                var id_class = '#'+string
                if(activa == ''){
                    $(id_class).addClass('active');
                    activa = id_class
                } else {
                    if(id_class != activa){
                        $(id_class).addClass('active'); 
                        $(activa).removeClass('active'); 
                        activa = id_class;
                    }
                }

                $('#agregar').prop('disabled', false);
                $('#quitar').prop('disabled', true);
            });

            $("li.activa_item").click(function(){
                var string = $(this).attr('id');
                var id = string.replace(/^activa+/i,'');
                etapa_id = id;
                var id_class = '#'+string
                if(activa == ''){
                    $(id_class).addClass('active');
                    activa = id_class;
                    class_button = '#button'+id;
                    $(class_button).removeAttr("style");
                    button_activa = class_button;
                } else {
                    if(id_class != activa){
                        $(id_class).addClass('active'); 
                        $(activa).removeClass('active'); 
                        activa = id_class;

                        class_button = '#button'+id;
                        $(button_activa).css("display", "none");
                        $(class_button).removeAttr("style");
                        button_activa = class_button;
                    }
                }

                $('#agregar').prop('disabled', true);
                $('#quitar').prop('disabled', false);
            });
        });
    </script>
@endpush
@endsection