<table class="table">
    <thead>
      <tr>
        <th scope="col">Actividad</th>
        <th scope="col">Prioridad</th>
        <th scope="col">Estado</th>
        <th scope="col">Encargado</th>
        <th scope="col">Fecha de entrega</th>
      </tr>
    </thead>
    <tbody>
        @foreach($actividades as $actividad)
            @if($actividad)
        <tr >
            <td>
                {{$actividad->nombre}}
            </td>
            <td>{{$actividad->prioridad}}</td>
            <td>{{$actividad->estado_id}}</td>
            <td>{{$actividad->usuario_asignado}}</td>
            <td>{{$actividad->fecha_entrega}}</td>
            <td>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
  </table>