@extends('layouts.app')

@section('content')
@push('styles')
    <style>
        .lock_image{
            margin-bottom: 10px;
        }

        .lock_image img{
            width: 70px;
            height: 70px;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }
    </style>
@endpush
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('error') || session('success'))
                <div class="col-lg-12">
                    <div class="form-panel">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                @include('alertas.index')
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="lock_image">
                <img src="{{asset('icons/candado.png')}}" >
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group row">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row">
                    <button type="submit" class="btn btn-lg btn-primary btn-block">
                        <strong>{{ __('Iniciar Sesión') }}</strong>
                    </button>
                </div>

                <div class="form-group row">
                    <a href="{{ url('auth/google') }}" class="btn btn-lg btn-primary btn-block">
                        <strong>Iniciar Sesión Con Google</strong>
                    </a> 
                </div>
            </form><br><br>
        </div>
    </div>
</div>
@push('scripts')
    
@endpush
@endsection
