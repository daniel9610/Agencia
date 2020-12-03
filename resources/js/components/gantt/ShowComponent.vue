<template>
    <div v-if="showGantt">
        <gantt-elastic
        :options="options"
        :tasks="tasks"
        @tasks-changed="tasksUpdate"
        @options-changed="optionsUpdate"
        @dynamic-style-changed="styleUpdate"
        >
            <gantt-header slot="header"></gantt-header>
        </gantt-elastic>
        <div class="q-mt-md" />
        <!-- <button @click="addTask">Add new task</button> -->
    </div>
</template>

<script>
import GanttElastic from "gantt-elastic";
import GanttHeader from "gantt-elastic-header";
import dayjs from "dayjs";
// just helper to get current dates
// function getDate(hours) {
//   const currentDate = new Date();
//   const currentYear = currentDate.getFullYear();
//   const currentMonth = currentDate.getMonth();
//   const currentDay = currentDate.getDate();
//   const timeStamp = new Date(
//     currentYear,
//     currentMonth,
//     currentDay,
//     0,
//     0,
//     0
//   ).getTime();
//   console.log(new Date(timeStamp + hours * 60 * 60 * 1000).getTime());
//   return new Date(timeStamp + hours * 60 * 60 * 1000).getTime();
// }

export default {
    name: "Gantt",
    components: {
        GanttElastic,
        GanttHeader
    },
    data() {
        return {
        tasks:[],
        options:[],
        dynamicStyle: {},
        lastId: 16,
        showGantt: false,
        };
    },
    mounted(){
        console.log(this.campania);
        console.log(this.etapas);
        console.log(this.campania_etapas);
        console.log(this.entregables);
        console.log(this.actividades);

        for(let i = 0; i < this.campania.length; i++){
            let porcentaje_aux_campania = 0;
            let porcentaje_campania = 0;
            let acum_campania = 0;
            let fecha_asignacion_campania = '';
            let fecha_entrega_campania = '';

            for(let j = 0; j< this.campania_etapas.length; j++){
                if(this.campania_etapas[j].campania_id == this.campania[i].id){
                    let porcentaje_aux = 0;
                    let porcentaje = 0;
                    let acum = 0;
                    let fecha_asignacion_etapa = '';
                    let fecha_entrega_etapa = '';

                    for(let k = 0; k < this.entregables.length; k++){
                        let porcentaje_aux_entregables = 0;
                        let porcentaje_entregables = 0;
                        let acum_entregables = 0;
                        let fecha_asignacion_entregables = '';
                        let fecha_entrega_entregables = '';
                        console.log(this.campania[i].id == this.entregables[k].campania_id &&
                        this.campania_etapas[j].etapa_id == this.entregables[k].etapa_id);
                        if(
                        this.campania[i].id == this.entregables[k].campania_id &&
                        this.campania_etapas[j].etapa_id == this.entregables[k].etapa_id
                        ){
                            for(let l = 0; l < this.actividades.length; l++){
                                if(
                                    this.campania[i].id == this.actividades[l].campania_id &&
                                    this.campania_etapas[j].etapa_id == this.actividades[l].etapa_id &&
                                    this.entregables[k].id == this.actividades[l].entregable_id
                                ){
                                    porcentaje_aux_entregables = porcentaje_aux_entregables + this.actividades[l].porcentaje;
                                    acum_entregables = acum_entregables + 1;

                                    if(fecha_asignacion_entregables == ''){
                                        fecha_asignacion_entregables = new Date(this.actividades[l].fecha_asignacion);
                                    } else {
                                        if(fecha_asignacion_entregables > new Date(this.actividades[l].fecha_asignacion)){
                                            fecha_asignacion_entregables = new Date(this.actividades[l].fecha_asignacion);
                                        }
                                    }

                                    if(fecha_entrega_entregables == ''){
                                        fecha_entrega_entregables = new Date(this.actividades[l].fecha_entrega);
                                    } else {
                                        if(fecha_entrega_entregables < new Date(this.actividades[l].fecha_entrega)){
                                            fecha_entrega_entregables = new Date(this.actividades[l].fecha_entrega);
                                        }
                                    }

                                    let fecha_asignacion = new Date(this.actividades[l].fecha_asignacion);
                                    let fecha_entrega = new Date(this.actividades[l].fecha_entrega);
                                    const diffTime = Math.abs(fecha_entrega - fecha_asignacion);
                                    const dias = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                                    this.tasks.push(
                                        {
                                            id: 'campania_'+this.campania[i].id+'_etapa_'+this.campania_etapas[j].id+'_entregables_'+this.entregables[k].id+'_actividad_'+this.actividades[l].id,
                                            label: this.actividades[l].nombre,
                                            user:this.actividades[l].name,
                                            parentId: 'campania_'+this.campania[i].id+'_etapa_'+this.campania_etapas[j].id+'_entregables_'+this.entregables[l].id,
                                            // getDate remplazarlo por el día de asignación de la tarea
                                            start: new Date(this.actividades[l].fecha_asignacion).getTime(),
                                            // 15 es la duración del task fecha entrega menos fecha asignación
                                            duration: dias * 24 * 60 * 60 * 1000,
                                            percent: this.actividades[l].porcentaje,
                                            type: "task",
                                            style: {
                                                base: {
                                                fill: "#0287D0",
                                                stroke: "#0077C0"
                                                }
                                            }
                                        }
                                    );

                                }
                                if(this.campania[i].id == this.actividades[l].campania_id){
                                    if(fecha_asignacion_campania == ''){
                                        fecha_asignacion_campania = new Date(this.actividades[l].fecha_asignacion);
                                    } else {
                                        if(fecha_asignacion_campania > new Date(this.actividades[l].fecha_asignacion)){
                                        fecha_asignacion_campania = new Date(this.actividades[l].fecha_asignacion);
                                        }
                                    }

                                    if(fecha_entrega_campania == ''){
                                        fecha_entrega_campania = new Date(this.actividades[l].fecha_entrega);
                                    } else {
                                        if(fecha_entrega_campania < new Date(this.actividades[l].fecha_entrega)){
                                        fecha_entrega_campania = new Date(this.actividades[l].fecha_entrega);
                                        }
                                    }
                                }

                            }
                            if(porcentaje_aux_entregables !== 0){
                                porcentaje_entregables = porcentaje_aux_entregables / acum_entregables;
                            }

                            porcentaje_aux = porcentaje_aux + porcentaje_entregables;
                            acum = acum + 1;

                            const diffTime = Math.abs(fecha_entrega_entregables - fecha_asignacion_entregables);
                            const dias_entregable = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                            this.tasks.push(
                                {
                                id: 'campania_'+this.campania[i].id+'_etapa_'+this.campania_etapas[j].id+'_entregables_'+this.entregables[k].id,
                                label: this.entregables[k].nombre,
                                // user:this.campania_etapas[i].encargado,
                                parentId:'campania_'+this.campania[i].id+'_etapa_'+this.campania_etapas[j].id,
                                // getDate remplazarlo por el día de asignación de la tarea
                                start: new Date(this.entregables[k].created_at).getTime(),
                                // suma de todas las duraciones
                                duration: dias_entregable * 24 * 60 * 60 * 1000,//primera fecha de la primera actividad y fecha de la ultima actividad
                                percent: porcentaje_entregables,//Suma de todas las actividades
                                type: "milestone",
                                collapsed: true,
                                style: {
                                    base: {
                                    fill: "#1EBC61",
                                    stroke: "#0EAC51"
                                    }
                                }
                                }
                            );
                        }
                    }

                    if(porcentaje_aux !== 0){
                        porcentaje = porcentaje_aux / acum;
                    }

                    porcentaje_aux_campania = porcentaje_aux_campania + porcentaje;
                    acum_campania = acum_campania + 1;

                    const diffTime = Math.abs(fecha_entrega_etapa - fecha_asignacion_etapa);
                    const dias_etapa = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    this.tasks.push(
                        {
                        id: 'campania_'+this.campania[i].id+'_etapa_'+this.campania_etapas[j].id,
                        label: this.campania_etapas[j].nombre,
                        // user:this.campania_etapas[i].encargado,
                        parentId:'campania_'+this.campania[i].id,
                        // getDate remplazarlo por el día de asignación de la tarea
                        start: new Date(this.campania_etapas[i].created_at).getTime(),
                        // suma de todas las duraciones
                        duration: dias_etapa * 24 * 60 * 60 * 1000,//primera fecha de la primera actividad y fecha de la ultima actividad
                        percent: porcentaje,//Suma de todas las actividades
                        type: "milestone",
                        collapsed: true,
                        style: {
                            base: {
                            fill: "#1EBC61",
                            stroke: "#0EAC51"
                            }
                        }
                        }
                    );

                }
            }
            if(porcentaje_aux_campania !== 0){
                porcentaje_campania = porcentaje_aux_campania / acum_campania;
            }
            const diffTime = Math.abs(fecha_entrega_campania - fecha_asignacion_campania);
            const dias_campania = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            this.tasks.push(
                {
                id: 'campania_'+this.campania[i].id,
                label: this.campania[i].nombre,
                user:this.campania[i].encargado,
                // getDate remplazarlo por el día de asignación de la tarea
                start: new Date(this.campania[i].created_at).getTime(),
                // suma de todas las duraciones
                duration: dias_campania * 24 * 60 * 60 * 1000,//primera fecha de las actividades sin etapa.
                percent: porcentaje_campania,//suma de todas las etapas
                type: "project"
                //collapsed: true,
                }
            );
        }

        this.options = {
        taskMapping: {
            progress: "percent"
        },
        maxRows: 100,
        maxHeight: 500,
        title: {
            label: "Your project title as html (link or whatever...)",
            html: false
        },
        row: {
            height: 24
        },
        calendar: {
            hour: {
            display: true
            }
        },
        chart: {
            progress: {
            bar: false
            },
            expander: {
            display: true
            }
        },
        taskList: {
            expander: {
            straight: false
            },
            columns: [
            {
                id: 1,
                label: "ID",
                value: "id",
                width: 40
            },
            {
                id: 2,
                label: "Descripción",
                value: "label",
                width: 200,
                expander: true,
                html: true,
                events: {
                click({ data, column }) {
                    alert("description clicked!\n" + data.label);
                }
                }
            },
            {
                id: 3,
                label: "Asignado a",
                value: "user",
                width: 130,
                html: true
            },
            {
                id: 3,
                label: "Empieza",
                value: task => dayjs(task.start).format("YYYY-MM-DD"),
                width: 78
            },
            {
                id: 4,
                label: "Tipo",
                value: "type",
                width: 68
            },
            {
                id: 5,
                label: "%",
                value: "progress",
                width: 35,
                style: {
                "task-list-header-label": {
                    "text-align": "center",
                    width: "100%"
                },
                "task-list-item-value-container": {
                    "text-align": "center",
                    width: "100%"
                }
                }
            }
            ]
        },
        locale: {
            name: "es",
            Now: "Now",
            "X-Scale": "Zoom-X",
            "Y-Scale": "Zoom-Y",
            "Task list width": "Task list",
            "Before/After": "Expand",
            "Display task list": "Task list"
        }
        };
        this.showGantt = true;
    },
    methods: {
    // addTask() {
    //   this.tasks.push({
    //     id: this.lastId++,
    //     label:
    //       '<a href="https://images.pexels.com/photos/423364/pexels-photo-423364.jpeg?auto=compress&cs=tinysrgb&h=650&w=940" target="_blank" style="color:#0077c0;">Yeaahh! you have added a task bro!</a>',
    //     user:
    //       '<a href="https://images.pexels.com/photos/423364/pexels-photo-423364.jpeg?auto=compress&cs=tinysrgb&h=650&w=940" target="_blank" style="color:#0077c0;">Awesome!</a>',
    //     start: getDate(24 * 3),
    //     duration: 1 * 24 * 60 * 60 * 1000,
    //     percent: 50,
    //     type: "project"
    //   });
    // },
        getDate(hours) {
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth();
            const currentDay = currentDate.getDate();
            const timeStamp = new Date(
                currentYear,
                currentMonth,
                currentDay,
                0,
                0,
                0
            ).getTime();
            console.log(new Date(timeStamp + hours * 60 * 60 * 1000).getTime());
            return new Date(timeStamp + hours * 60 * 60 * 1000).getTime();
        },
        tasksUpdate(tasks) {
            this.tasks = tasks;
        },
        optionsUpdate(options) {
            this.options = options;
        },
        styleUpdate(style) {
            this.dynamicStyle = style;
        }
    },
    props: [
        'campania',
        'etapas',
        'campania_etapas',
        'actividades',
        'entregables'
    ]
};
</script>
