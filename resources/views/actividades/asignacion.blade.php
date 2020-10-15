    <form action="{{ route('actividades.update', 1) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <label for="cliente">Usuario:</label><br>
        <select name="usuario_asignado" id="usuario_asignado" class="form-control" required>
            <option value=""></option>
            @foreach($users as $user)
                <option value="{{ $user->id }}"> {{ $user->name }} </option>
            @endforeach
        </select>

        <label for="actividad_id">Actividad:</label><br>
        <select name="actividad_id" id="actividad_id" class="form-control" required>
            <option value=""> </option>
            @foreach($actividades_a_asignar as $actividad)
                <option value="{{ $actividad->id }}"> {{ $actividad->nombre }} </option>
            @endforeach
        </select><br>

   <button  type="submit" class="btn btn-primary btn-lg btn-block">Asignar actividad</button>
    </form>