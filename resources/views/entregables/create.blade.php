
<form action="" method="" enctype="multipart/form-data">
</form>

<form action="{{ route('entregables.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="POST">
    <input type="hidden" name="campania_id" id="campania_id" value={{$campania_id}}><br>

    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" id="nombre" required class="form-control"><br>

    <label for="descripcion">Descripción:</label><br>
    <input type="text" name="descripcion" id="descripcion" required class="form-control"><br>

    <label for="etapa_id">Etapa:</label><br>
    <select name="etapa_id" id="etapa_id" class="form-control" required>
        <option value=""> </option>
        @foreach($etapas as $etapa)
            <option value="{{ $etapa->etapa_id }}"> {{ $etapa->nombre }} </option>
        @endforeach
    </select><br>

    <label for="fecha_entrega">Fecha de entrega:</label><br>
    <input type="date" name="fecha_entrega" id="fecha_entrega" required class="form-control"><br><br>


<button  type="submit" class="btn btn-primary btn-lg btn-block">Crear Entregable</button>
</form>