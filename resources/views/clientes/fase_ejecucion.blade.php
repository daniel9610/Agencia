{{-- clave = id, valor = nombre --}}
@foreach ($clientes as $cliente)
<div class="accordion" id="cliente{{$cliente->id}}"> 
    <div class="card">
        <div class="card-header" id="headingCampania{{$cliente->id}}">
            <h5 class="mb-0">
                {{ $cliente->nombre }}
                <button class="btn" type="button" data-toggle="collapse" data-target="#collapseCampania{{$cliente->id}}" aria-expanded="false" aria-controls="collapseCampania{{$cliente->id}}">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                    </svg>
                </button>
            </h5>
        </div>
        <div id="collapseCampania{{$cliente->id}}" class="collapse" aria-labelledby="headingCampania{{$cliente->id}}" data-parent="#cliente{{$cliente->id}}">
            <div class="card-body">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Campania</th>
                    <th scope="col">NIT</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Fecha de entrega</th>
                    <th scope="col">Porcentaje</th>
                    <th scope="col">Etapas</th>
                </tr>
                </thead>
                <tbody>
                    @if(count($campanias_fase_ejecucion) == 0)
                        No hay campañas en fase de ejecución
                    @else
                    @foreach($campanias_fase_ejecucion as $campania)
                        @if($cliente->id == $campania->cliente_id)
                            <tr >
                                <td>
                                    <a href="{{ route('campanias.show',  $campania->id) }}">{{$campania->nombre}}</a>
                                </td>
                                <td>{{$campania->NIT}}</td>
                                <td>{{$campania->categoria_id}}</td>
                                <td>{{$campania->fecha_entrega}}</td>
                                {{-- <td><progress value="{{$campania->porcentaje}}" max="100">{{$campania->porcentaje}} %</progress></td> --}}
                                {{-- <td>{{$campania->porcentaje}}</td> --}}
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: {{$campania->porcentaje}}%;" aria-valuenow="{{$campania->porcentaje}}" aria-valuemin="0" aria-valuemax="100">{{$campania->porcentaje}}%</div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('campania_etapas',  $campania->id) }}" class="btn btn-dark">Gestionar</a>
                                    @can('campanias.create')
                                        <a href="{{ route('creartablero' , $campania->id) }}" class="btn btn-dark">Tablero</a>
                                    @endcan
                                    {{-- <button class="btn btn-success" type="button" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-trash-alt"></i> Agregar</button> --}}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    @endif

                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>
@endforeach

