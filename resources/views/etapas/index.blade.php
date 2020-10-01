@extends('layouts.app')
@section('content')

<div>
    @if($campania_etapas == "vacio")

        No hay etapas asignadas a esta campaña
        <button class="btn btn-dark">Agregar etapas</button>   
     
    @else
        @foreach ($campania_etapas as $etapa)
        
            <a href="{{URL::current()}}/{{$etapa->url}}" class="btn btn-dark">{{$etapa->nombre}}</a>   
        @endforeach
    @endif 

</div><br><br>
<a class="btn btn-primary mr-auto" href="{{ URL::previous() }}"><i class="fas fa-arrow-left"></i> Atrás</a>


@endsection