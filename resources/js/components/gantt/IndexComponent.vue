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
    console.log(this.campanias);
    console.log(this.etapas);
    console.log(this.campania_etapas);
    console.log(this.actividades);
    for(let i = 0; i < this.campanias.length; i++){
      let porcentaje_aux_campania = 0;
      let porcentaje_campania = 0;
      let acum_campania = 0;
      let fecha_asignacion_campania = '';
      let fecha_entrega_campania = '';
      for(let j = 0; j< this.campania_etapas.length; j++){
        if(this.campania_etapas[j].campania_id == this.campanias[i].id){
          let porcentaje_aux = 0;
          let porcentaje = 0;
          let acum = 0;
          let fecha_asignacion_etapa = '';
          let fecha_entrega_etapa = '';
          for(let k = 0; k < this.actividades.length; k++){
            if(
              this.campanias[i].id == this.actividades[k].campania_id &&
              this.campania_etapas[j].etapa_id == this.actividades[k].etapa_id
            ){
              porcentaje_aux = porcentaje_aux + this.actividades[k].porcentaje;
              acum = acum + 1;
              if(fecha_asignacion_etapa == ''){
                fecha_asignacion_etapa = new Date(this.actividades[k].fecha_asignacion);
              } else {
                if(fecha_asignacion_etapa > new Date(this.actividades[k].fecha_asignacion)){
                  fecha_asignacion_etapa = new Date(this.actividades[k].fecha_asignacion);
                }
              }

              if(fecha_entrega_etapa == ''){
                fecha_entrega_etapa = new Date(this.actividades[k].fecha_entrega);
              } else {
                if(fecha_entrega_etapa < new Date(this.actividades[k].fecha_entrega)){
                  fecha_entrega_etapa = new Date(this.actividades[k].fecha_entrega);
                }
              }

              let fecha_asignacion = new Date(this.actividades[k].fecha_asignacion);
              let fecha_entrega = new Date(this.actividades[k].fecha_entrega);
              const diffTime = Math.abs(fecha_entrega - fecha_asignacion);
              const dias = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

              this.tasks.push(
                {
                  id: 'campania_'+this.campanias[i].id+'_etapa_'+this.campania_etapas[j].id+'_actividad_'+this.actividades[k].id,
                  label: this.actividades[k].nombre,
                  user:this.actividades[k].name,
                  parentId: 'campania_'+this.campanias[i].id+'_etapa_'+this.campania_etapas[j].id,
                  // getDate remplazarlo por el día de asignación de la tarea
                  start: new Date(this.actividades[k].fecha_asignacion).getTime(),
                  // 15 es la duración del task fecha entrega menos fecha asignación
                  duration: dias * 24 * 60 * 60 * 1000,
                  percent: this.actividades[k].porcentaje,
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

            if(this.campanias[i].id == this.actividades[k].campania_id){
              if(fecha_asignacion_campania == ''){
                fecha_asignacion_campania = new Date(this.actividades[k].fecha_asignacion);
              } else {
                if(fecha_asignacion_campania > new Date(this.actividades[k].fecha_asignacion)){
                  fecha_asignacion_campania = new Date(this.actividades[k].fecha_asignacion);
                }
              }

              if(fecha_entrega_campania == ''){
                fecha_entrega_campania = new Date(this.actividades[k].fecha_entrega);
              } else {
                if(fecha_entrega_campania < new Date(this.actividades[k].fecha_entrega)){
                  fecha_entrega_campania = new Date(this.actividades[k].fecha_entrega);
                }
              }
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
              id: 'campania_'+this.campanias[i].id+'_etapa_'+this.campania_etapas[j].id,
              label: this.campania_etapas[j].nombre,
              // user:this.campania_etapas[i].encargado,
              parentId:'campania_'+this.campanias[i].id,
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
          id: 'campania_'+this.campanias[i].id,
          label: this.campanias[i].nombre,
          user:this.campanias[i].encargado,
          // getDate remplazarlo por el día de asignación de la tarea
          start: new Date(this.campanias[i].created_at).getTime(),
          // suma de todas las duraciones
          duration: dias_campania * 24 * 60 * 60 * 1000,//primera fecha de las actividades sin etapa.
          percent: porcentaje_campania,//suma de todas las etapas
          type: "project"
          //collapsed: true,
        }
      );
    }
    
    /*this.tasks = [
      {
        id: 1,
        label: "Make some noise",
        user:
          '<a href="https://www.google.com/search?q=John+Doe" target="_blank" style="color:#0077c0;">John Doe</a>',
        // getDate remplazarlo por el día de asignación de la tarea
        start: this.getDate(-24 * 5),
        // 15 es la duración del task fecha entrega menos fecha asignación
        duration: 15 * 24 * 60 * 60 * 1000,
        percent: 85,
        type: "project"
        //collapsed: true,
      },
      {
        id: 2,
        label: "With great power comes great responsibility",
        user:
          '<a href="https://www.google.com/search?q=Peter+Parker" target="_blank" style="color:#0077c0;">Peter Parker</a>',
        parentId: 1,
        start: this.getDate(-24 * 4),
        duration: 4 * 24 * 60 * 60 * 1000,
        percent: 50,
        type: "milestone",
        collapsed: true,
        style: {
          base: {
            fill: "#1EBC61",
            stroke: "#0EAC51"
          }
        }
      },
      {
        id: 3,
        label: "Courage is being scared to death, but saddling up anyway.",
        user:
          '<a href="https://www.google.com/search?q=John+Wayne" target="_blank" style="color:#0077c0;">John Wayne</a>',
        parentId: 2,
        start: this.getDate(-24 * 3),
        duration: 2 * 24 * 60 * 60 * 1000,
        percent: 100,
        type: "task"
      },
      {
        id: 4,
        label: "Put that toy AWAY!",
        user:
          '<a href="https://www.google.com/search?q=Clark+Kent" target="_blank" style="color:#0077c0;">Clark Kent</a>',
        start: this.getDate(-24 * 2),
        duration: 2 * 24 * 60 * 60 * 1000,
        percent: 50,
        type: "task",
        dependentOn: [3]
      },
      {
        id: 5,
        label:
          "One billion, gajillion, fafillion... shabadylu...mil...shabady......uh, Yen.",
        user:
          '<a href="https://www.google.com/search?q=Austin+Powers" target="_blank" style="color:#0077c0;">Austin Powers</a>',
        parentId: 4,
        start: this.getDate(0),
        duration: 2 * 24 * 60 * 60 * 1000,
        percent: 10,
        type: "milestone",
        style: {
          base: {
            fill: "#0287D0",
            stroke: "#0077C0"
          }
        }
      },
      {
        id: 6,
        label: "Butch Mario and the Luigi Kid",
        user:
          '<a href="https://www.google.com/search?q=Mario+Bros" target="_blank" style="color:#0077c0;">Mario Bros</a>',
        parentId: 5,
        start: this.getDate(24),
        duration: 1 * 24 * 60 * 60 * 1000,
        percent: 50,
        type: "task",
        collapsed: true,
        style: {
          base: {
            fill: "#8E44AD",
            stroke: "#7E349D"
          }
        }
      },
      {
        id: 7,
        label: "Devon, the old man wanted me, it was his dying request",
        user:
          '<a href="https://www.google.com/search?q=Knight+Rider" target="_blank" style="color:#0077c0;">Knight Rider</a>',
        parentId: 2,
        dependentOn: [6],
        start: this.getDate(24 * 2),
        duration: 4 * 60 * 60 * 1000,
        percent: 20,
        type: "task",
        collapsed: true
      },
      {
        id: 8,
        label: "Hey, Baby! Anybody ever tell you I have beautiful eyes?",
        user:
          '<a href="https://www.google.com/search?q=Johhny+Bravo" target="_blank" style="color:#0077c0;">Johhny Bravo</a>',
        parentId: 7,
        dependentOn: [7],
        start: this.getDate(24 * 3),
        duration: 1 * 24 * 60 * 60 * 1000,
        percent: 0,
        type: "task"
      },
      {
        id: 9,
        label:
          "This better be important, woman. You are interrupting my very delicate calculations.",
        user:
          '<a href="https://www.google.com/search?q=Dexter\'s+Laboratory" target="_blank" style="color:#0077c0;">Dexter\'s Laboratory</a>',
        parentId: 8,
        dependentOn: [8, 7],
        start: this.getDate(24 * 4),
        duration: 4 * 60 * 60 * 1000,
        percent: 20,
        type: "task",
        style: {
          base: {
            fill: "#8E44AD",
            stroke: "#7E349D"
          }
        }
      },
      {
        id: 10,
        label: "current task",
        user:
          '<a href="https://www.google.com/search?q=Johnattan+Owens" target="_blank" style="color:#0077c0;">Johnattan Owens</a>',
        start: this.getDate(24 * 5),
        duration: 24 * 60 * 60 * 1000,
        percent: 0,
        type: "task"
      },
      {
        id: 11,
        label: "test task",
        user:
          '<a href="https://www.google.com/search?q=Johnattan+Owens" target="_blank" style="color:#0077c0;">Johnattan Owens</a>',
        start: this.getDate(24 * 6),
        duration: 24 * 60 * 60 * 1000,
        percent: 0,
        type: "task"
      },
      {
        id: 12,
        label: "test task",
        user:
          '<a href="https://www.google.com/search?q=Johnattan+Owens" target="_blank" style="color:#0077c0;">Johnattan Owens</a>',
        start: this.getDate(24 * 7),
        duration: 24 * 60 * 60 * 1000,
        percent: 0,
        type: "task",
        parentId: 11
      },
      {
        id: 13,
        label: "test task",
        user:
          '<a href="https://www.google.com/search?q=Johnattan+Owens" target="_blank" style="color:#0077c0;">Johnattan Owens</a>',
        start: this.getDate(24 * 8),
        duration: 24 * 60 * 60 * 1000,
        percent: 0,
        type: "task"
      },
      {
        id: 14,
        label: "test task",
        user:
          '<a href="https://www.google.com/search?q=Johnattan+Owens" target="_blank" style="color:#0077c0;">Johnattan Owens</a>',
        start: this.getDate(24 * 9),
        duration: 24 * 60 * 60 * 1000,
        percent: 0,
        type: "task"
      },
      {
        id: 15,
        label: "test task",
        user:
          '<a href="https://www.google.com/search?q=Johnattan+Owens" target="_blank" style="color:#0077c0;">Johnattan Owens</a>',
        start: this.getDate(24 * 16),
        duration: 24 * 60 * 60 * 1000,
        percent: 0,
        type: "task"
      }
    ];*/

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
    'campanias',
    'etapas',
    'campania_etapas',
    'actividades',
  ]
};
</script>