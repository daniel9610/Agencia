<form action="{{ route('actividades.store') }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="POST">
    @csrf
    <input type="hidden" name="campania_id" id="campania_id" value="{{$campania_id}}">

        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" id="nombre" required class="form-control"><br>
        
        @if($entregables_para_cliente != "No hay entregables")
        <label for="entregable_id">Entregable:</label><br>
        <select name="entregable_id" id="entregable_id" class="form-control" required>
            <option value=""> </option>
            @foreach($entregables_para_cliente as $entregable)
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

        <label for="usuario_asignado">Encargado:</label><br>
        <select name="usuario_asignado" id="usuario_asignado" class="form-control" required>
            <option value=""> </option>
            @foreach($users as $encargado)
                <option value="{{ $encargado->id }}"> {{ $encargado->name }} </option>
            @endforeach
        </select>

        {{-- <label for="encargado">Encargado:</label><br>
        <input type="text" name="encargado" id="encargado" required class="form-control"><br> --}}

        <label for="fecha_entrega">Fecha de entrega:</label><br>
        <input type="date" name="fecha_entrega" id="fecha_entrega" required class="form-control"><br><br>
        <button  type="submit" class="btn btn-primary btn-lg btn-block">Crear Actividad</button>
    </form>