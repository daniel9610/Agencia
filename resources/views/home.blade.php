@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
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
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                            <div class="card-body">
                                <form action="">
                                    <label for="cliente">cliente:</label><br>
                                    <select name="cliente" id="cliente_id">
                                        <option value="1">Cliente 1</option>
                                        <option value="2">Cliente 2</option>
                                    </select><br>

                                    <label for="nombre">Nombre:</label><br>
                                    <input type="text" name="nombre" id="nombre"><br>

                                    <label for="nit">NIT:</label><br>
                                    <input type="text" name="nit" id="nit"><br>

                                    <label for="encargado">Encargado:</label><br>
                                    <input type="text" name="encargado" id="encargado"><br>

                                    <label for="numero_contacto">Número de contacto:</label><br>
                                    <input type="text" name="numero_contacto" id="numero_contacto"><br>

                                    <label for="email">Email:</label><br>
                                    <input type="email" name="email" id="email"><br>

                                    <label for="fecha_entrega">Fecha de entrega:</label><br>
                                    <input type="fecha_entrega" name="fecha_entrega" id="fecha_entrega"><br><br>
                                    <button class="btn btn-primary" type="submit">Crear Campaña</button>
                                </form>
                            </div>
                        </div>
                        </div>
                        <div class="card">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                    
                        <!-- <a href="#" class="card-link btn btn-primary buttons-card-header">Fase de ejecución</a> -->
                    <a id="fase_ejecucion" class="btn btn-primary buttons-card-header" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Fase de ejecución</a>
                    <a id="fase_propuesta" class="btn btn-primary buttons-card-header" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Fase diseño de propuesta</a>

                        <!-- <a href="#" class="card-link btn btn-primary buttons-card-header">Fase diseño de propuesta</a> -->
                    </h5>
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body" id="fase_ejecucion_div">
                            {{-- Info desde base de datos --}}
                        </div>
                    </div>

                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                        <div class="card card-body">
                            Clientes en fase de diseño de propuesta
                        </div>
                    </div>

                    <!-- accordion -->

                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                            <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

             <!-- fin accordion -->

            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#fase_ejecucion').click(function(){
                $.ajax({
                url: 'cliente',
                type: 'GET',
                success: function(response)
                {
                    $('#fase_ejecucion_div').html(response);
                }
                });
            });
        });
    </script>
@endpush

@endsection
