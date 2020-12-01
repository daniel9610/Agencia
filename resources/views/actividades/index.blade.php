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
            <td>
              <select name="estado_id" id="estado_id" class="estado_id">        
                @foreach($estados as $estado)
                  <option value='{"estado": {{ $estado->id }}, "actividad": {{$actividad->id}}}' {{ $actividad->estado_id == $estado->id ? 'selected' : '' }}>{{$estado->nombre}}</option>
                @endforeach
              </select>
          </td>
          </form>
            {{-- {{$actividad->estado}} --}}

            <td>{{$actividad->usuario_asignado}}</td>
            <td>{{$actividad->fecha_entrega}}</td>
            <td>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
  </table>

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
    $(document).ready(function(){

        $('.estado_id').change(function(){
          console.log($(this).val());
          
          var valores = $.parseJSON($(this).val())
          var actividad = valores.actividad;
          var estado = valores.estado;
          console.log(actividad);

          // e.preventDefault(); 
          $.ajax({
                url: '{{url("cambiarestado/")}}'+'/'+actividad+'/'+estado,
                // data: $(this).val(),
                type: "GET",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(data){
                    alert("Estado cambiado correctamente");
                }, 
                error: function(){
                      alert("No se pudo cambiar de estado ");
              }

          }); 
         
        })
    });
    </script>

@endpush