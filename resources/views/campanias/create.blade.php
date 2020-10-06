
    <form action="{{ route('subir_folder') }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="POST">
    @csrf
        <label for="cliente">cliente:</label><br>
        {{-- <select name="cliente_id" id="cliente_id" class="form-control" required>
           // @foreach($campanias as $campania)
           // <option value="{{ $campania->id }}" {{ $category->id == $article->category_id ? 'selected' : '' }}> {{ $category->name }} </option>
         //   @endforeach
        </select> --}}
        {{-- campo para identificar de dónde llega la petición al controlador de google --}}
        <input type="hidden" name="es_campania" id="es_campania" value="es_campania"><br>

        <select name="cliente_id" id="cliente_id" required>
            <option value="1">Cliente 1</option>
            <option value="2">Cliente 2</option>
        </select><br>

        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" id="nombre" required><br>

        <label for="nit">NIT:</label><br>
        <input type="text" name="nit" id="nit" required><br>

        <label for="encargado">Encargado:</label><br>
        <input type="text" name="encargado" id="encargado" required><br>

        <label for="numero_contacto">Número de contacto:</label><br>
        <input type="number" name="numero_contacto" id="numero_contacto" required><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" required><br>

        <label for="fecha_entrega">Fecha de entrega:</label><br>
        <input type="date" name="fecha_entrega" id="fecha_entrega" required><br><br>
        <button  type="submit" class="btn btn-primary">Crear Campaña</button>
    </form>


    