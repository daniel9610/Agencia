<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Campania;
use App\Documento;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Support\Facades\Redirect;

class GoogleDriveController extends Controller
{
    public $drive;
    public $calendar;
    public function __construct(Google_Client $client){
        // dd($client);
        $this->middleware(function($request, $next) use ($client){
            $client->refreshToken(Auth::user()->refresh_token);
            $this->drive = new Google_Service_Drive($client);
            // $this->drive = new Google_Service_Drive($client);

            return $next($request);
        });
    }

    public function listarCampaniaFolder($campania_id){
        $drive_folder = Documento::where('campania_id', $campania_id)->get();
        $drive_id = $drive_folder[0]->drive_id;
        $this->ListFolders($drive_id);
        // $this->ListFolders('1oQfaTiRirgxtUWswJ5lGWKdwKi6dBxLX');
    }

    public function ListFolders($id){
        try{
            $query = "mimeType='application/vnd.google-apps.document' and '".$id."' in parents and trashed=false";

            $optParams = [
                'fields'=>'files(id,name)',
                'q'=>$query
            ];
    
            $results = $this->drive->files->ListFiles($optParams);
            $list = $results->getFiles();
            // dd($list);
            print view('campanias.index', compact('list'));
        }catch(Exception $e){
            Auth::logout();
            return redirect()->route('login')->with('message', [
                'type' => 'error',
                'text' => 'Refrescar usuario de google para drive'
            ]);
        }
      
    }

    public function uploadFiles(Request $request){
        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $mime_type = $file->getMimeType();
            $title = $file->getClientOriginalName();
            $description = $request->input('description');

            //Crear archivo en drive
            $drive_file = new Google_Service_Drive_DriveFile;
            $drive_file->setName($title);
            $drive_file->setDescription($description);
            $drive_file->setMimeType($mime_type);

            try {
                $createdFile = $this->drive->files->create($drive_file, [
                    'data' => file_get_contents($file),
                    'mimeType' => $mime_type,
                    'uploadType' => 'multipart'
                ]);

                $file_id = $createdFile->getId();

                return redirect('/home')
                    ->with('message', [
                        'type' => 'success',
                        'text' => "File was uploaded with the following ID: {$file_id}"
                ]);

            } catch (Exception $e) {
                return redirect('/home')
                    ->with('message', [
                        'type' => 'error',
                        'text' => 'An error occurred while trying to upload the file'
                    ]);

            }
        }
    }
    
    public function subirFoldersDrive(Request $request){
        // dd($this->drive);
        // dd($request->es_campania);
        $carpeta_nombre = $request->nombre;
        $documento = new Documento;
        if($request->es_campania){  
                $campania = new Campania;
            $campania->nombre = $request->nombre;
            $campania->nit = $request->nit;
            $campania->porcentaje = 0;
            $campania->cliente_id = $request->cliente_id;
            $campania->fase_id = 1;
            $campania->categoria_id = 1;
            $campania->encargado = $request->encargado;
            $campania->numero_contacto = $request->numero_contacto;
            $campania->email = $request->email;
            $campania->fecha_entrega = $request->fecha_entrega;
            $campania->activo = 1;
            try{
                $fileMetadata = new Google_Service_Drive_DriveFile(array(
                    'name' => $carpeta_nombre,
                    'mimeType' => 'application/vnd.google-apps.folder'));
                        $file = $this->drive->files->create($fileMetadata, array(
                    'fields' => 'id'));
            $campania->save();
            
            $documento->nombre = $carpeta_nombre;
            $documento->tipo = "carpeta campania";
            $documento->campania_id = $campania->id;
            $documento->usuario_id = Auth::user()->id;
            $documento->drive_id = $file->id;
            $documento->save();
            return redirect()->route('home');

            }catch(Exception $e){
                Auth::logout();
                return redirect()->route('login')->with('message', [
                    'type' => 'error',
                    'text' => 'Refrescar usuario de google para drive'
                ]);
            }
        }
        
        // $fileMetadata = new Google_Service_Drive_DriveFile(array(
        //     'name' => $carpeta_nombre,
        //     'mimeType' => 'application/vnd.google-apps.folder'));
        //         $file = $this->drive->files->create($fileMetadata, array(
        //     'fields' => 'id'));
        // return ['file_name'=>$carpeta_nombre,'file_id'=>$file->id];


    }

    public function listCalendar(){
    
    $service = new Google_Service_Calendar($client);
    // Print the next 10 events on the user's calendar.
    $calendarId = 'primary';
    $optParams = array(
    'maxResults' => 10,
    'orderBy' => 'startTime',
    'singleEvents' => true,
    'timeMin' => date('c'),
    );
    $results = $service->events->listEvents($calendarId, $optParams);
    $events = $results->getItems();

    if (empty($events)) {
        print "No upcoming events found.\n";
    } else {
        print "Upcoming events:\n";
        foreach ($events as $event) {
            $start = $event->start->dateTime;
            if (empty($start)) {
                $start = $event->start->date;
            }
            printf("%s (%s)\n", $event->getSummary(), $start);
            }
        }
    }

    public function crearEventosCalendar(Request $request){
        $campania_id = $request->campania_id;
        // <iframe src="https://calendar.google.com/calendar/embed?src=c_cjj12kru97qaa1pfh5ibvcblg8%40group.calendar.google.com&ctz=America%2FBogota" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
        $m=''; //for error messages
        $id_event=''; //id event created 
        $link_event; 
                        
        //configurar variable de entorno / set enviroment variable
        // putenv('GOOGLE_APPLICATION_CREDENTIALS=credenciales.json');
    
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes(['https://www.googleapis.com/auth/calendar']);
    
        //define id calendario
        $id_calendar='c_cjj12kru97qaa1pfh5ibvcblg8@group.calendar.google.com';//
        
        $dateTimeReunion = $request->fecha_reunion . $request->hora_reunion;
        $datetime_start = new \DateTime($dateTimeReunion);
        $datetime_end = new \DateTime($dateTimeReunion);
        
        //aumentamos una hora a la hora inicial/ add 1 hour to start date
        $time_end = $datetime_end->add(new \DateInterval('PT1H'));
        
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

                return view('etapas.kickoff', compact('campania_id'));
                
            }else{
                $m = "Hay ".$cont_events." eventos en ese rango de fechas";
                return Redirect::to('campaniaetapas/'.$campania_id.'/kickoff')
                ->with(compact('campania_id'))
                ->with('error',$m);
            }
    
    
        }catch(Google_Service_Exception $gs){
            
            $m = json_decode($gs->getMessage());
            $m= $m->error->message;
            return Redirect::to('campaniaetapas/'.$campania_id.'/kickoff')
                ->with(compact('campania_id'))
                ->with('error',$m);
    
        }catch(Exception $e){
            $m = $e->getMessage();
            return Redirect::to('campaniaetapas/'.$campania_id.'/kickoff')
                ->with(compact('campania_id'))
                ->with('error',$m);
        }
            
    }

}