<template>
<!-- color = '#fcf88a'; //Amarillo
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
        'en_proceso',
    'en_revision',
    'terminado',
    'en_ajustes',
    'aprobado'-->
  <div class="row justify-content-center">
    <div class="container mt-5">
      <div class="row">
        <div class="col form-inline">
          <button
          @click="showSlideCreate"
          class="ml-3 btn btn-primary"
          >Agregar Actividad</button>
          <div :style="{
            height: '100%',
            background: '#fcf88a',
            borderRadius: '40px',
            textAlign: 'center',
            marginRight: '20px',
            marginLeft: '20px',
          }">
            <p style="color: #000000">Sin iniciar {{this.sin_iniciar}}</p>
          </div>
          <div :style="{
            height: '100%',
            background: '#9e00ff',
            borderRadius: '40px',
            textAlign: 'center',
            marginRight: '20px',
          }">
            <p style="color: #000000">En Proceso {{this.en_proceso}}</p>
          </div>
          <div :style="{
            height: '100%',
            background: '#a6ff81',
            borderRadius: '40px',
            textAlign: 'center',
            marginRight: '20px',
          }">
            <p style="color: #000000">En revisión {{this.en_revision}}</p>
          </div>
          <div :style="{
            height: '100%',
            background: '#8597ff',
            borderRadius: '40px',
            textAlign: 'center',
            marginRight: '20px',
          }">
            <p style="color: #000000">Terminado {{this.terminado}}</p>
          </div>
          <div :style="{
            height: '100%',
            background: '#f7a07a',
            borderRadius: '40px',
            textAlign: 'center',
            marginRight: '20px',
          }">
            <p style="color: #000000">En ajustes {{this.en_ajustes}}</p>
          </div>
          <div :style="{
            height: '100%',
            background: '#bfe1be',
            borderRadius: '40px',
            textAlign: 'center',
            marginRight: '20px',
          }">
            <p style="color: #000000">Aprobado {{this.aprobado}}</p>
          </div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-3" v-if="showInvestigacionBrief">
          <div class="card">
            <div class="card-header" :style="{
              background:'#d9edf7',
              fontSize:'12px',
              fontFamily: 'Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif',
              fontWeight: 700,
              color: 'rgb(106, 108, 111)',
              display: 'inline'
            }">
              Generar investigación de brief
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
              </svg>
              <span style="color:#62cb31">{{investigacionBriefCount}}</span>
            </div>
            <div class="card-body">
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
                    background:'rgb(52, 73, 94)',
                    color:'#ffffff',
                    marginBottom: '20px'
                  }"
                >
                  <div class="row">
                    <div class="col-md-7">
                      <p class="text-justify" style="font-size:12px">Encargado: {{ element.usuario_encargado }}</p>
                      <img alt="No se encontro la url" class="rounded-circle " :src="element.photo" style="width: 40px;height: auto" v-if="element.photo !== null">
                      <img alt="No hay foto" class="rounded-circle " src="https://picsum.photos/70" style="width: 40px;height: auto" v-else>
                    </div>
                    <div class="col-md-5">
                      <div class="float-e-margins pull right">
                        <button class="btn btn-xs btn-success edit-item" @click="showSlideEdit(element.id)">
                          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-mutedd font-bold m-b-xs">Tarea: {{ element.nombre }}</p>
                      <p class="text-justify" style="font-size:12px">{{element.descripcion}}</p>
                      <p class="text-justify" style="font-size:12px">{{element.fecha_entrega}}</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="float-e-margins pull right">
                        <div :style="{
                          width: '100%',
                          height: '100%',
                          background: element.color,
                          borderRadius: '40px',
                          textAlign: 'center'
                        }">
                          <p style="color: #000000">{{element.estado}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </draggable>
            </div>
          </div>
        </div>

        <div class="col-3" v-if="showAlinearEstrategia">
          <div class="card">
            <div class="card-header" :style="{
              background:'#d9edf7',
              fontSize:'12px',
              fontFamily: 'Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif',
              fontWeight: 700,
              color: 'rgb(106, 108, 111)',
              display: 'inline'
            }">
            Generar y alinear estrategia
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
              </svg>
              <span style="color:#62cb31">{{AlinearEstrategiaCount}}</span>
            </div>
            <div class="card-body">
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
                    background:'rgb(52, 73, 94)',
                    color:'#ffffff',
                    marginBottom: '20px'
                  }"
                >
                  <div class="row">
                    <div class="col-md-7">
                      <p class="text-justify" style="font-size:12px">Encargado: {{ element.usuario_encargado }}</p>
                      <img alt="No se encontro la url" class="rounded-circle " :src="element.photo" style="width: 40px;height: auto" v-if="element.photo !== null">
                      <img alt="No hay foto" class="rounded-circle " src="https://picsum.photos/70" style="width: 40px;height: auto" v-else>
                    </div>
                    <div class="col-md-5">
                      <div class="float-e-margins pull right">
                        <button class="btn btn-xs btn-success edit-item" @click="showSlideEdit(element.id)">
                          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-mutedd font-bold m-b-xs">Tarea: {{ element.nombre }}</p>
                      <p class="text-justify" style="font-size:12px">{{element.descripcion}}</p>
                      <p class="text-justify" style="font-size:12px">{{element.fecha_entrega}}</p></div>
                    </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="float-e-margins pull right">
                        <div :style="{
                          width: '100%',
                          height: '100%',
                          background: element.color,
                          borderRadius: '40px',
                          textAlign: 'center'
                        }">
                          <p style="color: #000000">{{element.estado}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </draggable>
            </div>
          </div>
        </div>

        <div class="col-3" v-if="showGenerarCreatividad">
          <div class="card">
            <div class="card-header" :style="{
              background:'#d9edf7',
              fontSize:'12px',
              fontFamily: 'Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif',
              fontWeight: 700,
              color: 'rgb(106, 108, 111)',
              display: 'inline'
            }">
             Generar Creatividad
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
              </svg>
              <span style="color:#62cb31">{{GenerarCreatividadCount}}</span>
            </div>
            <div class="card-body">
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
                    background:'rgb(52, 73, 94)',
                    color:'#ffffff',
                    marginBottom: '20px'
                  }"
                >
                  <div class="row">
                    <div class="col-md-7">
                      <p class="text-justify" style="font-size:12px">Encargado: {{ element.usuario_encargado }}</p>
                      <img alt="No se encontro la url" class="rounded-circle " :src="element.photo" style="width: 40px;height: auto" v-if="element.photo !== null">
                      <img alt="No hay foto" class="rounded-circle " src="https://picsum.photos/70" style="width: 40px;height: auto" v-else>
                    </div>
                    <div class="col-md-5">
                      <div class="float-e-margins pull right">
                        <button class="btn btn-xs btn-success edit-item" @click="showSlideEdit(element.id)">
                          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-mutedd font-bold m-b-xs">Tarea: {{ element.nombre }}</p>
                      <p class="text-justify" style="font-size:12px">{{element.descripcion}}</p>
                      <p class="text-justify" style="font-size:12px">{{element.fecha_entrega}}</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="float-e-margins pull right">
                        <div :style="{
                          width: '100%',
                          height: '100%',
                          background: element.color,
                          borderRadius: '40px',
                          textAlign: 'center'
                        }">
                          <p style="color: #000000">{{element.estado}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </draggable>
            </div>
          </div>
        </div>

        <div class="col-3" v-if="showPlanearEjecucion">
          <div class="card">
            <div class="card-header" :style="{
              background:'#d9edf7',
              fontSize:'12px',
              fontFamily: 'Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif',
              fontWeight: 700,
              color: 'rgb(106, 108, 111)',
              display: 'inline'
            }">
           Planear Ejecución
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
              </svg>
              <span style="color:#62cb31">{{PlanearEjecucionCount}}</span>
            </div>
            <div class="card-body">
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
                    background:'rgb(52, 73, 94)',
                    color:'#ffffff',
                    marginBottom: '20px'
                  }"
                >
                  <div class="row">
                    <div class="col-md-7">
                      <p class="text-justify" style="font-size:12px">Encargado: {{ element.usuario_encargado }}</p>
                      <img alt="No se encontro la url" class="rounded-circle " :src="element.photo" style="width: 40px;height: auto" v-if="element.photo !== null">
                      <img alt="No hay foto" class="rounded-circle " src="https://picsum.photos/70" style="width: 40px;height: auto" v-else>
                    </div>
                    <div class="col-md-5">
                      <div class="float-e-margins pull right">
                        <button class="btn btn-xs btn-success edit-item" @click="showSlideEdit(element.id)">
                          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                          </svg>
                        </button>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-mutedd font-bold m-b-xs">Tarea: {{ element.nombre }}</p>
                      <p class="text-justify" style="font-size:12px">{{element.descripcion}}</p>
                      <p class="text-justify" style="font-size:12px">{{element.fecha_entrega}}</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="float-e-margins pull right">
                        <div :style="{
                          width: '100%',
                          height: '100%',
                          background: element.color,
                          borderRadius: '40px',
                          textAlign: 'center'
                        }">
                          <p style="color: #000000">{{element.estado}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </draggable>
            </div>
          </div>
        </div>
      </div>
    </div>
    <slideout-panel></slideout-panel>
  </div>
</template>

<script>
import draggable from "vuedraggable";
export default {
  components: { draggable },
  props: [
    'campania_etapas',
    'actividades',
    'campania_id',
    'estados',
    'entregables',
    'users',
    'sin_iniciar',
    'en_proceso',
    'en_revision',
    'terminado',
    'en_ajustes',
    'aprobado',
    'entregables'
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
      showPlanearEjecucion: false,
      investigacionBriefCount:0,
      AlinearEstrategiaCount:0,
      GenerarCreatividadCount:0,
      PlanearEjecucionCount:0,
      showDialog: false,
      id_actividad_seleccionada: '',
    };
  },
  mounted() {
console.log(this.entregables)
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
        this.investigacionBriefCount ++
        this.arrInvestigacionBrief.push(this.actividades[i]);
      } else if(this.actividades[i].etapa_id == 4){
        this.actividades[i].color = color;
        this.actividades[i].texto = texto;
        this.AlinearEstrategiaCount++;
        this.arrAlinearEstrategia.push(this.actividades[i]);
      } else if(this.actividades[i].etapa_id == 5){
        this.actividades[i].color = color;
        this.actividades[i].texto = texto;
        this.GenerarCreatividadCount++;
        this.arrGenerarCreatividad.push(this.actividades[i]);
      } else if(this.actividades[i].etapa_id == 6){
        this.actividades[i].color = color;
        this.actividades[i].texto = texto;
        this.PlanearEjecucionCount++;
        this.arrPlanearEjecucion.push(this.actividades[i]);
      }
    }
  },
  computed: {

  },
  methods: {
    showSlideCreate(){
      const sliderpanel = this.$showPanel({
        component : 'tableroform-component',
        openOn : 'right',
        width: 700,
        props: {
          campania_id : this.campania_id,
          estados : this.estados,
          entregables : this.entregables,
          etapas: this.campania_etapas,
          users: this.users,
          mode: 'create',
          actividad: ''
        }
      })

      sliderpanel.promise
      .then(result => {
        if(!result.closedBy){
          window.location = "/creartablero/"+this.campania_id;
        }
      });
    },
    showSlideEdit(id_actividad){
      for(let i = 0; i < this.actividades.length; i++){
        if(this.actividades[i].id == id_actividad){
          const sliderpanel = this.$showPanel({
            component : 'tableroform-component',
            openOn : 'right',
            width: 700,
            props: {
              campania_id : this.campania_id,
              estados : this.estados,
              entregables : this.entregables,
              etapas: this.campania_etapas,
              users: this.users,
              mode: 'edit',
              actividad: this.actividades[i]
            }
          })

          sliderpanel.promise
          .then(result => {
            if(!result.closedBy){
              window.location = "/creartablero/"+this.campania_id;
            }
          });
        }
      }
    },
  }
};
</script>
