<template>
    <div class="row justify-content-center">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <form method="POST" enctype="multipart/form-data">
                        <label for="nombre">Nombre:</label><br>
                        <input v-model="nombre" type="text" name="nombre" id="nombre" required class="form-control"><br>

                        <label for="descripcion">Descripción:</label><br>
                        <textarea v-model="descripcion" type="text" name="descripcion" id="descripcion" required class="form-control" cols="30" rows="10"></textarea><br>

                        <label for="prioridad">Prioridad:</label><br>
                        <select v-model="prioridad" name="prioridad" id="prioridad" class="form-control" required>
                                <option value=""> </option>
                                <option value="Alta"> Alta </option>
                                <option value="Media"> Media </option>
                                <option value="Baja"> Baja </option>
                        </select>

                        <label for="etapa_id">Etapa:</label><br>
                        <select v-model="etapa_id" name="etapa_id" id="etapa_id" class="form-control" required>
                            <option value=""> </option>
                            <option :value="etapa.etapa_id" v-for="(etapa, index) in etapas" :key="index"> {{ etapa.nombre }} </option>
                        </select>

                        <label for="estado_id">Estado:</label><br>
                        <select v-model="estado_id" name="estado_id" id="estado_id" class="form-control" required>
                            <option value=""> </option>
                            <option :value="estado.id" v-for="(estado, index) in estados" :key="index"> {{ estado.nombre }} </option>
                        </select>

                        <label for="user_id">Asignar a:</label><br>
                        <select v-model="user_id" name="user_id" id="user_id" class="form-control" required>
                            <option value=""> </option>
                            <option :value="user.id" v-for="(user, index) in users" :key="index"> {{ user.name }} </option>
                        </select>

                        <label for="fecha_entrega">Fecha de entrega:</label><br>
                        <input v-model="fecha" type="date" name="fecha_entrega" id="fecha_entrega" required class="form-control" :min="date_min"><br><br>
                        <button  type="button" class="btn btn-primary btn-lg btn-block" @click="saveActividad" v-if="mode =='create'">Crear Actividad</button>
                        <button  type="button" class="btn btn-primary btn-lg btn-block" @click="saveActividad" v-else>Editar Actividad</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components: {

    },
    props: [
    'campania_id',
    'estados',
    'etapas',
    'users',
    'mode',
    'actividad'
    ],
    data() {
        return {
            nombre:'',
            descripcion:'',
            prioridad: '',
            etapa_id:'',
            estado_id: '',
            user_id: '',
            fecha: '',
            date_min: new Date()
        };
    },
    mounted() {
        this.date_min = this.date_min.getFullYear()+'-'+(this.date_min.getMonth()+1)+'-'+this.date_min.getDate();
        if(this.mode == 'edit'){
            let fecha = new Date(this.actividad.fecha_entrega);
            let fecha_entrega = fecha.getFullYear()+'-'+(fecha.getMonth()+1)+'-'+fecha.getDate();
            this.nombre = this.actividad.nombre,
            this.descripcion = this.actividad.descripcion,
            this.prioridad = this.actividad.prioridad,
            this.etapa_id = this.actividad.etapa_id,
            this.estado_id = this.actividad.estado_id,
            this.user_id = this.actividad.user_id,
            this.fecha = fecha_entrega;
        }
    },
    computed: {

    },
    methods: {
        saveActividad(){
            if(this.mode == 'create'){
                if(
                    this.nombre!==''&&
                    this.descripcion !==''&&
                    this.prioridad !== ''&&
                    this.etapa_id !==''&&
                    this.estado_id !== ''&&
                    this.user_id !== ''&&
                    this.fecha !== ''
                ){
                    let url = '/guardarActividad';
                    axios
                    .post(
                        url,
                        {
                            nombre:this.nombre,
                            descripcion:this.descripcion,
                            prioridad:this.prioridad,
                            campania_id:this.campania_id,
                            etapa_id: this.etapa_id,
                            estado_id:this.estado_id,
                            usuario_asignado: this.user_id,
                            fecha_entrega:this.fecha,
                        }
                    )
                    .then((response)=>{
                        this.closePanel();
                    })
                    .catch((error)=>{
                        console.error(error);
                    })
                } else {
                    alert('Faltan campos por diligenciar');
                }
            } else {
                console.log('Holi');
                if(
                    this.nombre!==''&&
                    this.descripcion !==''&&
                    this.prioridad !== ''&&
                    this.etapa_id !==''&&
                    this.estado_id !== ''&&
                    this.user_id !== ''&&
                    this.fecha !== ''
                ){
                    let url = '/actualizarActividad/'+this.actividad.id;
                    axios
                    .post(
                        url,
                        {
                            nombre:this.nombre,
                            descripcion:this.descripcion,
                            prioridad:this.prioridad,
                            estado_id:this.estado_id,
                            usuario_asignado: this.user_id,
                            fecha_entrega:this.fecha,
                        }
                    )
                    .then((response)=>{
                        this.closePanel();
                    })
                    .catch((error)=>{
                        console.error(error);
                    })
                } else {
                    alert('Faltan campos por diligenciar');
                }
            }
        },
        closePanel() {
            this.$emit('closePanel', {});
        },
    }
};
</script>