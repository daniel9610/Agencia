@extends('layouts.app')
@section('content')
    <tablero-component :actividades="{{ $actividades }}" :campania_etapas="{{ $campania_etapas }}"></tablero-component>
@endsection