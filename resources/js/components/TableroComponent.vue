<template>

  <div class="row justify-content-center">
    <div class="container mt-5">
      <div class="row">
        <div class="col form-inline">
          <b-form-input
            id="input-2"
            v-model="newTask"
            required
            placeholder="Enter Task"
            @keyup.enter="add"
          ></b-form-input>
          <b-button @click="add" variant="primary" class="ml-3">Add</b-button>
        </div>
      </div>
      <div class="row mt-5" v-if="showInvestigacionBrief">
        <div class="col-3">
          <div class="p-2 alert alert-secondary">
            <h3 :style="{fontSize:15+'px'}">Generar investigación de brief</h3>
            <!-- Backlog draggable component. Pass arrBackLog to list prop -->
            <draggable
              class="list-group kanban-column"
              :list="arrInvestigacionBrief"
              group="tasks"
              :options="{disabled : true}"
            >
              <div
                class="list-group-item"
                v-for="element in arrInvestigacionBrief"
                :key="element.id"
                :style="{
                  background:element.color,
                  color: element.texto
                }"
              >
                {{ element.nombre }}
              </div>
            </draggable>
          </div>
        </div>

        <div class="col-3" v-if="showAlinearEstrategia">
          <div class="p-2 alert alert-primary">
            <h3 :style="{fontSize:15+'px'}">Generar y alinear estrategia</h3>
            <!-- In Progress draggable component. Pass arrInProgress to list prop -->
            <draggable
              class="list-group kanban-column"
              :list="arrAlinearEstrategia"
              group="tasks"
              :options="{disabled : true}"
            >
              <div
                class="list-group-item"
                v-for="element in arrAlinearEstrategia"
                :key="element.id"
                :style="{
                  background:element.color,
                  color: element.texto
                }"
              >
                {{ element.nombre }}
              </div>
            </draggable>
          </div>
        </div>

        <div class="col-3" v-if="showGenerarCreatividad">
          <div class="p-2 alert alert-warning">
            <h3 :style="{fontSize:15+'px'}">Generar Creatividad</h3>
            <!-- Testing draggable component. Pass arrTested to list prop -->
            <draggable
              class="list-group kanban-column"
              :list="arrGenerarCreatividad"
              group="tasks"
              :options="{disabled : true}"
            >
              <div
                class="list-group-item"
                v-for="element in arrGenerarCreatividad"
                :key="element.id"
                :style="{
                  background:element.color,
                  color: element.texto
                }"
              >
                {{ element.nombre }}
              </div>
            </draggable>
          </div>
        </div>

        <div class="col-3" v-if="showPlanearEjecucion">
          <div class="p-2 alert alert-success">
            <h3 :style="{fontSize:15+'px'}">Planear Ejecución</h3>
            <!-- Done draggable component. Pass arrDone to list prop -->
            <draggable
              class="list-group kanban-column"
              :list="arrPlanearEjecucion"
              group="tasks"
              :options="{disabled : true}"
            >
              <div
                class="list-group-item"
                v-for="element in arrPlanearEjecucion"
                :key="element.id"
                style="background"
                :style="{
                  background:element.color,
                  color: element.texto
                }"
              >
                {{ element.nombre }}
              </div>
            </draggable>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import draggable from "vuedraggable";
export default {
  components: { draggable },
  props: [
    'campania_etapas',
    'actividades'
  ],
  data() {
    return {
      // for new tasks
      newTask: "",
      // 4 arrays to keep track of our 4 statuses
      arrInvestigacionBrief: [],
      arrAlinearEstrategia: [],
      arrGenerarCreatividad: [],
      arrPlanearEjecucion: [],
      showInvestigacionBrief: false,
      showAlinearEstrategia: false,
      showGenerarCreatividad: false,
      showPlanearEjecucion: false
    };
  },
  mounted() {
    console.log(this.actividades);
    console.log(this.campania_etapas);

    for(let i = 0; i < this.campania_etapas.length; i++){
      if(this.campania_etapas[i].etapa_id == 3){
        this.showInvestigacionBrief = true;
      } else if(this.campania_etapas[i].etapa_id == 4){
        this.showAlinearEstrategia = true;
      } else if(this.campania_etapas[i].etapa_id == 5){
        this.showGenerarCreatividad = true;
      } else if(this.campania_etapas[i].etapa_id == 6){
        this.showPlanearEjecucion = true;
      }
    }

    for(let i = 0; i < this.actividades.length; i++){
      let color = '';
      let texto = ''
      if(this.actividades[i].estado_id == 10){
        color = '#fcf88a'; //Amarillo
        texto = '#000000';
      } else if(this.actividades[i].estado_id == 11){
        color = '#9e00ff'; //Morado
        texto = '#ffffff';
      } else if(this.actividades[i].estado_id == 12){
        color = '#a6ff81'; //Verde claro
        texto = '#000000';
      } else if(this.actividades[i].estado_id == 13){
        color = '#8597ff'; //Azul
        texto = '#000000';
      } else if(this.actividades[i].estado_id == 14){
        color = '#f7a07a'; //Naranja
        texto = '#000000';
      } else if(this.actividades[i].estado_id == 15){
        color = '#bfe1be'; //Verde oscuro
        texto = '#000000';
      }


      if(this.actividades[i].etapa_id == 3){
        this.actividades[i].color = color;
        this.actividades[i].texto = texto;
        this.arrInvestigacionBrief.push(this.actividades[i]);
      } else if(this.actividades[i].etapa_id == 4){
        this.actividades[i].color = color;
        this.actividades[i].texto = texto;
        this.arrAlinearEstrategia.push(this.actividades[i]);
      } else if(this.actividades[i].etapa_id == 5){
        this.actividades[i].color = color;
        this.actividades[i].texto = texto;
        this.arrGenerarCreatividad.push(this.actividades[i]);
      } else if(this.actividades[i].etapa_id == 6){
        this.actividades[i].color = color;
        this.actividades[i].texto = texto;
        this.arrPlanearEjecucion.push(this.actividades[i]);
      }
    }
  },
  computed: {

  },
  methods: {
    add: function() {
      if (this.newTask) {
        this.arrBackLog.push({ name: this.newTask });
        this.newTask = "";
      }
    }
  }
};
</script>