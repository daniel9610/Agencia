<div class="container">
    <h1>{{$campania_gantt[0]->nombre}}</h1>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <planearejecucion-component
            :campania = "{{$campania_gantt}}"
            :entregables = "{{$entregables_para_cliente}}"
            :actividades = "{{$actividades_gantt}}"
            ></planearejecucion-component>
        </div>
    </div>
</div>
