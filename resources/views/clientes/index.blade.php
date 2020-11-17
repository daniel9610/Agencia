@foreach ($clientes as $clave => $valor)
<div class="accordion" id="cliente{{$clave}}"> 
    <div class="card">
        <div class="card-header" id="headingCampania{{$clave}}">
            <h5 class="mb-0">
                {{ $valor }}
                <button class="btn" type="button" data-toggle="collapse" data-target="#collapseCampania{{$clave}}" aria-expanded="false" aria-controls="collapseCampania{{$clave}}">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-compact-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67z"/>
                    </svg>
                </button>
            </h5>
        </div>
        <div id="collapseCampania{{$clave}}" class="collapse" aria-labelledby="headingCampania{{$clave}}" data-parent="#cliente{{$clave}}">
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
                    @foreach($campanias as $campania)
                        @if($clave == $campania->cliente_id)
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
                    <!-- Modal -->
                    {{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header header-title">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-trash-alt"></i> Agregar etapas a la campaña {{$campania->nombre}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @foreach ($etapas as $etapa)

                                    <a href="{{ route('agregarcampaniaetapa', $campania->id, $etapa->id, 1) }}" class="btn btn-dark">{{$etapa->nombre}}</a>

                                @endforeach
                    
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('destroy-form').submit();"><i class="fas fa-check"></i> Eliminar</button>
                            </div>
                          </div>
                        </div>
                      </div> --}}
                    @endforeach
                </tbody>
              </table>
            </div>
        </div>
    </div>
</div>

{{-- 
<div class="col-md-12">
    <div class="modal-footer">
        <a class="btn btn-primary mr-auto" href="{{ URL::previous() }}"><i class="fas fa-arrow-left"></i> Atrás</a>
        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-trash-alt"></i> Eliminar</button>
        <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Guardar</button>
    </div>
  </div> --}}

@endforeach
