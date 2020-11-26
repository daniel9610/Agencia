<?php

namespace App\Repositories;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;


// use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class googleRepository.
 */
class GoogleRepository
{
    /**
     * @return string
     *  Return the model
     */

    public function subirFoldersDrive(Request $request, $drive){

        $carpeta_nombre = $request->nombre;
        if($request->es_campania){

            try{
                //crear folder con nombre de la campania en drive
                $fileMetadata = new Google_Service_Drive_DriveFile(array(
                    'name' => $carpeta_nombre,
                    'mimeType' => 'application/vnd.google-apps.folder'));
                        $file = $drive->files->create($fileMetadata, array(
                    'fields' => 'id'));
            return $file;

            }catch(Exception $e){
                Auth::logout();
                return redirect()->route('login')->with('message', [
                    'type' => 'error',
                    'text' => 'Refrescar usuario de google para drive'
                ]);
            }
        }
    }

    public function ListarFolders($id, $drive, $tipo_archivo){
        try{
            $query1 = " '".$id."' in parents and trashed=false";
            // $query2 = " mimeType='application/vnd.google-apps.spreadsheet' and '".$id."' in parents and trashed=false";

            $optParams = [
                'fields'=>'files(id,name)',
                'q'=>$query1
            ];
            $results = $drive->files->ListFiles($optParams);
            $list = $results->getFiles();
            if(count($list) == 0){
                $list = "Sin archivos";
            }
            return $list;

        }catch(Exception $e){
            Auth::logout();
            return redirect()->route('login')->with('message', [
                'type' => 'error',
                'text' => 'Refrescar usuario de google para drive'
            ]);
        }
    }

    public function subirArchivos(Request $request, $drive, $carpeta_padre){

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
            $drive_file->setParents(array($carpeta_padre));

            try {
                $createdFile = $drive->files->create($drive_file, [
                    'data' => file_get_contents($file),
                    'mimeType' => $mime_type,
                    'uploadType' => 'multipart'
                ]);

                $file_id = $createdFile->getId();
                return $file_id;

            } catch (Exception $e) {
                return json_encode("error en la carga de archivo".$e);

            }
        }
    }

    public function crearCalendario(Request $request, $cliente){
               //Crear calendario con nombre de la campania en calendar
            //   env('GOOGLE_APPLICATION_CREDENTIALS');

            $carpeta_nombre = $request->nombre;

            // $client = new Google_Client();
            // $client->useApplicationDefaultCredentials();
            // $client->setScopes(['https://www.googleapis.com/auth/calendar']);

            // $service = new Google_Service_Calendar($client);
            // $calendar = new Google_Service_Calendar_Calendar($client);
            // $calendar->setSummary($carpeta_nombre);
            // $calendar->setTimeZone('America/Bogota');

            // $createdCalendar = $service->calendars->insert($calendar);
            // // dd($createdCalendar);
            // return $createdCalendar;

            //Nuevo intento
            $client = new \Google_Client();
            $client->setClientId(env('GOOGLE_CLIENT_ID'));
            $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
            $client->setRedirectUri(env('GOOGLE_REDIRECT_URL'));
            $client->setScopes(explode(',', env('GOOGLE_SCOPES')));
            $client->setApprovalPrompt(env('GOOGLE_APPROVAL_PROMPT'));
            $client->setAccessType(env('GOOGLE_ACCESS_TYPE'));
            $client->setAccessToken(json_encode($cliente->getAccessToken()));

            $title = $carpeta_nombre;
            $timezone = env('APP_TIMEZONE');

            $cal = new \Google_Service_Calendar($client);

            $google_calendar = new \Google_Service_Calendar_Calendar($client);
            $google_calendar->setSummary($title);
            $google_calendar->setTimeZone($timezone);

            $created_calendar = $cal->calendars->insert($google_calendar);

            return $created_calendar;
    }

    public function crearEventosCalendar($campania_id, $id_calendar, $dateTimeReunion, $nombre, $descripcion, $cliente){

        // $campania_id = $request->campania_id;
        // <iframe src="https://calendar.google.com/calendar/embed?src=c_cjj12kru97qaa1pfh5ibvcblg8%40group.calendar.google.com&ctz=America%2FBogota" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
        $m=''; //for error messages
        $id_event=''; //id event created
        $link_event;

        $client = new \Google_Client();
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URL'));
        $client->setScopes(explode(',', env('GOOGLE_SCOPES')));
        $client->setApprovalPrompt(env('GOOGLE_APPROVAL_PROMPT'));
        $client->setAccessType(env('GOOGLE_ACCESS_TYPE'));
        $client->setAccessToken(json_encode($cliente->getAccessToken()));

        //configurar variable de entorno / set enviroment variable
        //env('GOOGLE_APPLICATION_CREDENTIALS');

        // $client = new Google_Client();
        // $client->useApplicationDefaultCredentials();
        // $client->setScopes(['https://www.googleapis.com/auth/calendar']);

        $datetime_start = new \DateTime($dateTimeReunion);
        $datetime_end = new \DateTime($dateTimeReunion);

        //aumentamos una hora a la hora inicial/ add 1 hour to start date
        $time_end = $datetime_end->add(new \DateInterval('PT1H'));

        //datetime debe estar en formato RFC3339
        $time_start =$datetime_start->format(\DateTime::RFC3339);
        $time_end=$time_end->format(\DateTime::RFC3339);

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
                $event->setSummary($nombre);
                $event->setDescription($descripcion);

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

                return Redirect::back()
                ->with('success', 'Evento creado correctamente');

            }else{
                $m = "Hay ".$cont_events." evento(s) en ese rango de fechas";
                return Redirect::back()
                ->with('error',$m);
            }


        }catch(Google_Service_Exception $gs){

            $m = json_decode($gs->getMessage());
            $m= $m->error->message;
            return Redirect::back()
                ->with('error',$m);

        }catch(Exception $e){
            $m = $e->getMessage();
            return Redirect::back()
                ->with('error',$m);
        }
    }
}
