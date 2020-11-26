@extends('layouts.app')

@section('content')
<div class="container">
    @if (Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ Session::get('success') }}</li>
        </ul>
    </div>
@endif
    <div class="row justify-content-center">
    @can('campanias.create')
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="accordion" id="accordionExample">

                        <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                Crear Campaña
                                <button class="btn" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                                    </svg>
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">

                                @include('campanias.create')
                            </div>
                        </div>
                        </div>
                        {{-- <div class="card">
                        <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                Collapsible Group Item #3
                                <button class="btn" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                                    </svg>
                                </button>
                            </h5>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        @endcan
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                <!-- pestañas -->
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                          <a class="nav-item nav-link active" id="nav-fase-disenio-tab" data-toggle="tab" href="#nav-fase-disenio" role="tab" aria-controls="nav-fase-disenio" aria-selected="true">Fase diseño de propuesta</a>
                          <a class="nav-item nav-link" id="nav-fase-ejecucion-tab" data-toggle="tab" href="#nav-fase-ejecucion" role="tab" aria-controls="nav-fase-ejecucion" aria-selected="false">Fase de ejecución</a>
                        </div>
                      </nav>
                      <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-fase-disenio" role="tabpanel" aria-labelledby="nav-fase-disenio-tab">
                            @include('clientes.fase_disenio_propuesta')
                        </div>
                        <div class="tab-pane fade" id="nav-fase-ejecucion" role="tabpanel" aria-labelledby="nav-fase-ejecucion-tab">
                            @include('clientes.fase_ejecucion')

                        </div>
                      </div>

             <!-- fin pestañas -->

            </div>
        </div>
    </div>
</div>

@endsection
