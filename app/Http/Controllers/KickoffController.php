<?php

namespace App\Http\Controllers;

use App\Kickoff;
use Illuminate\Http\Request;
use Google_Service_Calendar;
use Google_Client;

class KickoffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kickoff  $kickoff
     * @return \Illuminate\Http\Response
     */
    public function show(Kickoff $kickoff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kickoff  $kickoff
     * @return \Illuminate\Http\Response
     */
    public function edit(Kickoff $kickoff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kickoff  $kickoff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kickoff $kickoff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kickoff  $kickoff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kickoff $kickoff)
    {
        //
    }

    public function crearEventosCalendar(){
        // <iframe src="https://calendar.google.com/calendar/embed?src=c_cjj12kru97qaa1pfh5ibvcblg8%40group.calendar.google.com&ctz=America%2FBogota" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
        $m=''; //for error messages
        $id_event=''; //id event created 
        $link_event; 
        if(isset($_POST['agendar'])){
                        
            //configurar variable de entorno / set enviroment variable
            // putenv('GOOGLE_APPLICATION_CREDENTIALS=credenciales.json');
        
            $client = new Google_Client();
            $client->useApplicationDefaultCredentials();
            $client->setScopes(['https://www.googleapis.com/auth/calendar']);
        
            //define id calendario
            $id_calendar='c_cjj12kru97qaa1pfh5ibvcblg8@group.calendar.google.com';//
            
            
                
            $datetime_start = new DateTime($_POST['date_start']);
            $datetime_end = new DateTime($_POST['date_start']);
            
            //aumentamos una hora a la hora inicial/ add 1 hour to start date
            $time_end = $datetime_end->add(new DateInterval('PT1H'));
            
            //datetime must be format RFC3339
            $time_start =$datetime_start->format(\DateTime::RFC3339);
            $time_end=$time_end->format(\DateTime::RFC3339);
        
            
            $nombre=(isset($_POST['username']))?$_POST['username']:' xyz ';
            try{
                
                //instanciamos el servicio
                    $calendarService = new Google_Service_Calendar($client);
                
                
                
                //parámetros para buscar eventos en el rango de las fechas del nuevo evento
                //params to search events in the given dates
                $optParams = array(
                    'orderBy' => 'startTime',
                    'maxResults' => 20,
                    'singleEvents' => TRUE,
                    'timeMin' => $time_start,
                    'timeMax' => $time_end,
                );
        
                //obtener eventos 
                $events=$calendarService->events->listEvents($id_calendar,$optParams);
                
                //obtener número de eventos / get how many events exists in the given dates
                $cont_events=count($events->getItems());
                
                //crear evento si no hay eventos / create event only if there is no event in the given dates
                if($cont_events == 0){
        
                    $event = new Google_Service_Calendar_Event();
                    $event->setSummary('Cita con el paciente '.$nombre);
                    $event->setDescription('Revisión , Tratamiento');
        
                    //fecha inicio
                    $start = new Google_Service_Calendar_EventDateTime();
                    $start->setDateTime($time_start);
                    $event->setStart($start);
        
                    //fecha fin
                    $end = new Google_Service_Calendar_EventDateTime();
                    $end->setDateTime($time_end);
                    $event->setEnd($end);
        
                    
                    $createdEvent = $calendarService->events->insert($id_calendar, $event);
                    $id_event= $createdEvent->getId();
                    $link_event= $createdEvent->gethtmlLink();
                    
                }else{
                    $m = "Hay ".$cont_events." eventos en ese rango de fechas";
                }
        
        
            }catch(Google_Service_Exception $gs){
                
                $m = json_decode($gs->getMessage());
                $m= $m->error->message;
        
            }catch(Exception $e){
                $m = $e->getMessage();
                
            }
        }
            
    }
}
