<form action="{{ route('actividades.store', $campania_id, $etapa_id) }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="POST">
    @csrf
    <input type="hidden" name="campania_id" id="campania_id" value="{{$campania_id}}">
    <input type="hidden" name="etapa_id" id="etapa_id" value="{{$etapa_id}}">

        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" id="nombre" required class="form-control"><br>
        
        @if($entregables != "No hay entregables")
        <label for="entregable_id">Entregable:</label><br>
        <select name="entregable_id" id="entregable_id" class="form-control" required>
            <option value=""> </option>
            @foreach($entregables as $entregable)
                <option value="{{ $entregable->id }}"> {{ $entregable->nombre }} </option>
            @endforeach
        </select>
        @endif
        
        <label for="prioridad">Prioridad:</label><br>
        <select name="prioridad" id="prioridad" class="form-control" required>
                <option value=""> </option>
                <option value="Alta"> Alta </option>
                <option value="Media"> Media </option>
                <option value="Baja"> Baja </option>
        </select>

        <label for="estado_id">Estado:</label><br>
        <select name="estado_id" id="estado_id" class="form-control" required>
            <option value=""> </option>
            @foreach($estados_actividades as $estado)
                <option value="{{ $estado->id }}"> {{ $estado->nombre }} </option>
            @endforeach
        </select>

        {{-- <label for="encargado">Encargado:</label><br>
        <input type="text" name="encargado" id="encargado" required class="form-control"><br> --}}

        <label for="fecha_entrega">Fecha de entrega:</label><br>
        <input type="date" name="fecha_entrega" id="fecha_entrega" required class="form-control"><br><br>
        <button  type="submit" class="btn btn-primary btn-lg btn-block">Crear Actividad</button>
    </form>