Lista de archivos drive             
<div class="links">
    @foreach($list as $file)
        <button class="btn btn-primary"> {{ $file->getName() }}</button>
    @endforeach
</div>