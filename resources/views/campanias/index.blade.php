
@extends('layouts.app')

@section('content')
<div class="links">
    @foreach($list as $file)
        <button class="btn btn-primary"><i class="fad fa-file-alt"></i> {{ $file->getName() }}</button>
    @endforeach
</div>
@stop
