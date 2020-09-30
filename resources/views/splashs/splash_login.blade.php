@push('styles')
    
@endpush
@extends('layouts.app')
@section('content')
    <div class="splash">
        <div class="splash_logo">
            Hola
        </div>
        <div class="splash_svg">
            <svg width="100%" height="100%">
                <rect width="100%" height="100%" ></rect>
            </svg>
        </div>
        <div class="splash_minimize">
            <svg width="100%" height="100%">
                <rect width="100%" height="100%" ></rect>
            </svg>
        </div>
    </div>
    <div class="text">
        <p>Bienvenidos a agencia.</p>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        setTimeout(()=>{
            window.location = "/home";
        },5000);
    </script>
@endpush