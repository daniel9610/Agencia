<?php

trait GoogleTrait
{

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

}