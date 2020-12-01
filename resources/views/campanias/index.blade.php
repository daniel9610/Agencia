
@extends('layouts.app')

@section('content')
<div class="links">
    @if($list != "Sin archivos")
    @foreach($list as $file)
        <a target="_blank" href="https://drive.google.com/open?id={{ $file->getId() }}" class="btn btn-primary"><i class="fad fa-file-alt"></i> {{ $file->getName() }}</a>
    @endforeach
    @else
     {{$list}}
    @endif
</div><br><br>
<a class="btn btn-primary mr-auto btn-lg btn-block" href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Atrás</a>

@stop
